<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [stripe] process for the pay
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Pay;

use Illuminate\Contracts\Support\Responsable;

class StripePaymentResponse implements Responsable {

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

        //fire event
        event(new \App\Events\Invoices\Responses\InvoicePaymentStripe($request, $this->payload));

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

        //generate paynow button
        $html = view('pages/pay/stripe', compact('session_id'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#invoice-paynow-buttons-container',
            'action' => 'replace',
            'value' => $html,
        );

        // POSTRUN FUNCTIONS------
        $jsondata['postrun_functions'][] = [
            'value' => 'NXStripePaymentButton',
        ];

        //response
        return response()->json($jsondata);
    }
}
