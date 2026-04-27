<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [create] process for the invoices
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Invoices;

use Illuminate\Contracts\Support\Responsable;

class CreateResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for invoices
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //fire event to allow modules to extend form data
        event(new \App\Events\Invoices\Responses\InvoiceCreate($this->payload));

        //fire event to allow modules to extend form data (when creating from expense)
        if (request()->segment(1) == 'expenses' && request()->segment(3) == 'invoice') {
            event(new \App\Events\Expenses\Responses\ExpenseCreateInvoice($request, $this->payload));
        }

        //[events] process module injections - push content to blade stacks
        if (isset($this->payload['module_injections'])) {
            foreach ($this->payload['module_injections'] as $injection) {
                try {
                    view()->startPush($injection['stack']);
                    echo $injection['content'];
                    view()->stopPush();
                } catch (Exception $e) {
                    //nothing
                }
            }
        }

        //render the form
        $html = view('pages/invoices/components/modals/add-edit-inc', compact('page', 'categories', 'fields', 'tags', 'invoice_due_days', 'invoice_due_days_text'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#commonModalBody',
            'action' => 'replace',
            'value' => $html,
        );

        //show modal invoiceter
        $jsondata['dom_visibility'][] = array('selector' => '#commonModalFooter', 'action' => 'show');

        // POSTRUN FUNCTIONS------
        $jsondata['postrun_functions'][] = [
            'value' => 'NXInvoiceCreate',
        ];

        $jsondata['postrun_functions'][] = [
            'value' => 'NXInvoiceCalculateInitialDueDate',
        ];

        //ajax response
        return response()->json($jsondata);
    }
}
