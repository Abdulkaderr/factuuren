<?php

/** --------------------------------------------------------------------------------
 * This class renders the response for the [store] process for the Refunds controller
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Refunds;

use Illuminate\Contracts\Support\Responsable;

class StoreResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * Prepend new row or replace full table on first record, then close modal
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //unpack payload into local variables
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //first record — replace full table wrapper to show headers
        if ($count == 1) {
            $html = view('pages/refunds/components/table/table', compact('refunds'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => '#refunds-table-wrapper',
                'action'   => 'replace-with',
                'value'    => $html);
        } else {
            //prepend new row on top of existing list
            $html = view('pages/refunds/components/table/ajax', compact('refunds'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => '#refunds-td-container',
                'action'   => 'prepend',
                'value'    => $html);
        }

        //close modal
        $jsondata['dom_visibility'][] = array('selector' => '#commonModal', 'action' => 'close-modal');

        //success notification
        $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));

        return response()->json($jsondata);
    }
}
