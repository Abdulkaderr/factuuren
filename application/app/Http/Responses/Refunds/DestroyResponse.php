<?php

/** --------------------------------------------------------------------------------
 * This class renders the response for the [destroy] process for the Refunds controller
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Refunds;

use Illuminate\Contracts\Support\Responsable;

class DestroyResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * Slide up and remove each deleted row, then show success notification
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //unpack payload into local variables
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //hide and remove all deleted rows
        foreach ($allrows as $id) {
            $jsondata['dom_visibility'][] = array(
                'selector' => '#refund_' . $id,
                'action'   => 'slideup-slow-remove',
            );
        }

        //success notification
        $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));

        return response()->json($jsondata);
    }
}
