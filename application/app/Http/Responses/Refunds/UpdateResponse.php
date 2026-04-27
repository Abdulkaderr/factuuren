<?php

/** --------------------------------------------------------------------------------
 * This class renders the response for the [update] process for the Refunds controller
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Refunds;

use Illuminate\Contracts\Support\Responsable;

class UpdateResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * Replace the updated table row, close modal, and show success notification
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //unpack payload into local variables
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //replace the updated row in the table
        $html = view('pages/refunds/components/table/ajax', compact('refunds'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#refund_' . $id,
            'action'   => 'replace-with',
            'value'    => $html);

        //close modal
        $jsondata['dom_visibility'][] = array('selector' => '#commonModal', 'action' => 'close-modal');

        //success notification
        $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));

        return response()->json($jsondata);
    }
}
