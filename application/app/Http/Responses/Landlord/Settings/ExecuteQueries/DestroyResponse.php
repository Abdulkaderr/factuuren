<?php

/** --------------------------------------------------------------------------------
 * This class renders the response for the [destroy] process for execute queries
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Landlord\Settings\ExecuteQueries;
use Illuminate\Contracts\Support\Responsable;

class DestroyResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * Render the response for deleting query
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        // Set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        // Remove row from table
        $jsondata['dom_visibility'][] = [
            'selector' => '#query_' . $query_id,
            'action' => 'fadeout-remove',
        ];

        // Show notification
        $jsondata['notification'] = [
            'type' => 'success',
            'value' => __('lang.request_has_been_completed'),
        ];

        // Response
        return response()->json($jsondata);
    }
}
