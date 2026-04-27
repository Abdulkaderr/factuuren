<?php

/** -------------------------------------------------------------------------------------------------
 * Email Bills Cronob
 * Send invoice/estimate emails that need to generate a PDF file and attach it.
 * These emails are limited to a smaller number at a time (e.g. 5)
 * This cronjob is envoked by by the task scheduler which is in 'application/app/Console/Kernel.php'
 *      - the scheduler is set to run this every minuted
 *      - the schedler itself is evoked by the signle cronjob set in cpanel (which runs every minute)
 * @package    Grow CRM
 * @author     NextLoop
 *---------------------------------------------------------------------------------------------------*/

namespace App\Cronjobs;
use App\Mail\SendQueued;
use App\Repositories\EstimateGeneratorRepository;
use Exception;
use App\Repositories\InvoiceGeneratorRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Log;
use PDF;

class EmailBillsCron {

    public function __invoke(
        InvoiceGeneratorRepository $invoicegenerator,
        EstimateGeneratorRepository $estimategenerator
    ) {

        //[MT] - tenants only
        if (env('MT_TPYE')) {
            if (\Spatie\Multitenancy\Models\Tenant::current() == null) {
                return;
            }
        }

        //boot system settings
        middlewareBootSettings();

        //[MT] boot mail settings
        env('MT_TPYE') ? middlewareSaaSBootMail() : middlewareBootMail();

        //boot theme for pdf css
        middlewareBootTheme();

        //set the language to be used in this cronjon session
        $this->setLanguage();

        //delete emails without an email address
        \App\Models\EmailQueue::Where('emailqueue_to', '')->delete();

        /**
         * Generate PDF invoices and email them out
         *   - These emails are being sent every minute. You can set a higher or lower sending limit.
         *   - Note: processing PDF files takes some time and if you set too high a limit, the process
         *    could timeout
         */
        //Get the emails marked as [pdf] and [invoice]
        $limit = 5;
        if ($emails = \App\Models\EmailQueue::Where('emailqueue_type', 'pdf')
            ->whereIn('emailqueue_pdf_resource_type', ['invoice', 'estimate'])->where('emailqueue_status', 'new')->take($limit)->get()) {

            //mark all emails in the batch as processing - to avoid batch duplicates/collisions
            foreach ($emails as $email) {
                $email->update([
                    'emailqueue_status' => 'processing',
                    'emailqueue_started_at' => now(),
                ]);
            }

            //process each email in the batch
            foreach ($emails as $email) {

                //fire email processing event
                event(new \App\Events\EmailBills\EmailProcessing($email->emailqueue_id));

                //id of original bill
                $bill_id = $email->emailqueue_pdf_resource_id;

                //[invoice]
                if ($email->emailqueue_pdf_resource_type == 'invoice') {
                    if (!$payload = $invoicegenerator->generate($bill_id)) {
                        Log::error("the invoice could not be generated", ['process' => '[cronjob][email-bills]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'bill_id' => $bill_id]);
                    }
                }

                //[estimate]
                if ($email->emailqueue_pdf_resource_type == 'estimate') {
                    if (!$payload = $estimategenerator->generate($bill_id)) {
                        Log::error("the estimate could not be generated", ['process' => '[Email Bills Cronjob]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'bill_id' => $bill_id]);
                    }
                }

                //save the pdf file to disk
                $attachment = $this->savePDF($payload);

                //send email with attachement (only to a valid email address)
                if ($email->emailqueue_to != '') {
                    //send email - wrapped in try/catch to capture and log delivery failures
                    try {
                        Mail::to($email->emailqueue_to)->send(new SendQueued($email, $attachment));
                    } catch (Exception $e) {
                        $error_message = $e->getMessage();

                        //[MT] multi-tenant error logging
                        if (env('MT_TPYE')) {
                            if ($tenant = \Spatie\Multitenancy\Models\Tenant::current()) {
                                $domain = $tenant->domain;

                                //log the failure to the landlord database
                                $db_log = new \App\Models\Landlord\Log();
                                $db_log->log_resource_type = 'email-delivery-error';
                                $db_log->log_resource_id = $tenant->id;
                                $db_log->log_title = 'Email delivery failed';
                                $db_log->log_body = $error_message;
                                $db_log->save();

                                Log::error("Failed to send email for tenant ($domain). Error: $error_message", ['email-sending-cron', config('app.debug_ref'), basename(__FILE__), __line__]);
                            } else {
                                Log::error("Failed to send email. Error: $error_message", ['email-sending-cron', config('app.debug_ref'), basename(__FILE__), __line__]);
                            }
                        } else {
                            Log::error("Failed to send email. Error: $error_message", ['email-sending-cron', config('app.debug_ref'), basename(__FILE__), __line__]);
                        }
                    }

                    //log email
                    $log = new \App\Models\EmailLog();
                    $log->emaillog_email = $email->emailqueue_to;
                    $log->emaillog_subject = $email->emailqueue_subject;
                    $log->emaillog_body = $email->emailqueue_message;
                    $log->emaillog_attachment = $attachment['filename'];
                    $log->save();
                }

                //fire email processed event
                event(new \App\Events\EmailBills\EmailProcessed($email->emailqueue_id, $payload));

                //delete email from the queue
                \App\Models\EmailQueue::Where('emailqueue_id', $email->emailqueue_id)->delete();

                //reset last cron run data
                \App\Models\Settings::where('settings_id', 1)
                    ->update([
                        'settings_cronjob_has_run' => 'yes',
                        'settings_cronjob_last_run' => now(),
                    ]);
            }
        }

        //[UPCOMING] update database for items marked as processing but never completed. Mark them as 'new'. Based on processing timestamp

    }

    /**
     * Render the PDF invoice and save it to disk (temp folder)
     *  @return array filename & filepath
     */
    public function savePDF($payload) {

        //set all data to arrays
        foreach ($payload as $key => $value) {
            $$key = $value;
        }

        //set blade template path
        $payload['blade'] = 'pages/bill/bill-pdf';

        //fire PDF saving event
        $bill_id = $bill->bill_type == 'invoice' ? $bill->bill_invoiceid : $bill->bill_estimateid;
        event(new \App\Events\EmailBills\PDFSaving($bill_id, $payload));

        //fire appropriate show event to allow modules to extend the payload (QR codes, custom fields, etc.)
        //create request object for event (cronjob context has no HTTP request)
        $request = request();

        //[invoice] fire InvoiceShow event
        if ($bill->bill_type == 'invoice') {
            //set flag to indicate PDF generation
            config(['response.pdf-invoice' => true]);
            event(new \App\Events\Invoices\Responses\InvoiceShow($request, $payload));
        }

        //[estimate] fire EstimateShow event
        if ($bill->bill_type == 'estimate') {
            //set flag to indicate PDF generation
            config(['response.pdf-estimate' => true]);
            event(new \App\Events\Estimates\Responses\EstimateShow($request, $payload));
        }

        //process module injections - push content to blade stacks (QR codes, custom fields, etc.)
        if (isset($payload['module_injections'])) {
            foreach ($payload['module_injections'] as $injection) {
                try {
                    view()->startPush($injection['stack']);
                    echo $injection['content'];
                    view()->stopPush();
                } catch (\Exception $e) {
                    //nothing
                }
            }
        }

        //unique file id & directory name
        $uniqueid = Str::random(40);
        $directory = $uniqueid;

        //[invoice] pdf filename
        if ($bill->bill_type == 'invoice') {
            $filename = strtoupper(__('lang.invoice')) . '-' . $bill->formatted_bill_invoiceid . '.pdf'; //invoice_inv0001.pdf
        }

        //[estimate] pdf filename
        if ($bill->bill_type == 'estimate') {
            $filename = strtoupper(__('lang.estimate')) . '-' . $bill->formatted_bill_estimateid . '.pdf'; //estimate_est0001.pdf
        }

        //filepath
        $filepath = BASE_DIR . "/storage/temp/$directory/$filename";

        //custom fields
        $customfields = \App\Models\CustomField::Where('customfields_type', 'clients')->get();

        //save file
        config(['css.bill_mode' => 'pdf-mode-download']);
        $pdf = PDF::loadView($payload['blade'], compact('bill', 'taxrates', 'taxes', 'elements', 'lineitems', 'customfields', 'payload'));

        //save file
        Storage::put("temp/$directory/$filename", $pdf->output());

        //prepare payload
        $result = [
            'filename' => $filename,
            'filepath' => $filepath,
        ];

        //fire PDF saved event
        event(new \App\Events\EmailBills\PDFSaved($bill_id, $result));

        //return the file path
        return $result;

    }

    /**
     * set the language to be used by the app
     * @return void
     */
    private function setLanguage() {

        //set the language to be used in this cronjon session
        $lang = config('system.settings_system_language_default');
        if (file_exists(resource_path("lang/$lang"))) {
            \App::setLocale($lang);
        } else {
            \App::setLocale('english');
        }
    }
}