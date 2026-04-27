<?php

/** --------------------------------------------------------------------------------
 * This class renders the response for the [index] process for execute queries
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Landlord\Settings\ExecuteQueries;
use Illuminate\Contracts\Support\Responsable;

class IndexResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * Render the view for execute queries page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        // Set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        // Render main page
        $html = view('landlord/settings/sections/executequeries/page', compact('page', 'queries'))->render();

        return $html;
    }
}
