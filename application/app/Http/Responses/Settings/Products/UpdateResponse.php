<?php

/** --------------------------------------------------------------------------------
 * This class renders the response for the update process for product custom fields settings
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Settings\Products;

use Illuminate\Contracts\Support\Responsable;

class UpdateResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * Handle the update response
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        // Extract payload
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        // Success notification
        $jsondata['notification'] = [
            'type' => 'success',
            'value' => __('lang.request_has_been_completed'),
        ];

        return response()->json($jsondata);
    }
}
