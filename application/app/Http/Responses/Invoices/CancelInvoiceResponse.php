<?php

/** --------------------------------------------------------------------------------
 * This class renders the response for the [cancel invoice] process
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Invoices;
use Illuminate\Contracts\Support\Responsable;

class CancelInvoiceResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the cancel form or return the post-cancel response
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to variables
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //show the cancel form
        if (isset($invoice)) {
            config(['response.show' => true]);
            $html = view('pages/invoices/components/modals/cancel-invoice', compact('invoice', 'has_payments'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => '#commonModalBody',
                'action'   => 'replace',
                'value'    => $html,
            );
            return response()->json($jsondata);
        }

        //close modal
        $jsondata['dom_visibility'][] = array('selector' => '#commonModal', 'action' => 'close-modal');

        //notice
        $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));

        //reload the page to reflect new status and cancellation panel
        $jsondata['redirect_url'] = request()->server('HTTP_REFERER');

        return response()->json($jsondata);
    }
}
