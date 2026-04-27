<?php

/** --------------------------------------------------------------------------------
 * Renders the response after creating tasks from estimate line items
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Estimates;

use Illuminate\Contracts\Support\Responsable;

class StoreTasksResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * return success response after tasks have been created
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //close the modal
        $jsondata['dom_visibility'][] = [
            'selector' => '#commonModal',
            'action'   => 'close-modal',
        ];

        //success notification
        $jsondata['notification'] = [
            'type'  => 'success',
            'value' => __('lang.request_has_been_completed'),
        ];

        return response()->json($jsondata);
    }
}
