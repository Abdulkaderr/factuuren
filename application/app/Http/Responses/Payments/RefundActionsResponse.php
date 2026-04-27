<?php

/** --------------------------------------------------------------------------------
 * This class renders the response for the refund create/destroy process on the
 * Payments list page. It re-renders the affected payment row.
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Payments;

use Illuminate\Contracts\Support\Responsable;

class RefundActionsResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * Re-render the payment row after a refund create or destroy action
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //unpack payload
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //replace the payment row
        $html = view('pages/payments/components/table/ajax', compact('payments'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#payment_' . $payment_id,
            'action'   => 'replace-with',
            'value'    => $html,
        );

        //close modal
        $jsondata['dom_visibility'][] = array(
            'selector' => '#commonModal',
            'action'   => 'close-modal',
        );

        //success notification
        $jsondata['notification'] = array(
            'type'  => 'success',
            'value' => __('lang.request_has_been_completed'),
        );

        return response()->json($jsondata);
    }
}
