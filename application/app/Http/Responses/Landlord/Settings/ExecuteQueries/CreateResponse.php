<?php

/** --------------------------------------------------------------------------------
 * This class renders the response for the [create] process for execute queries
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Landlord\Settings\ExecuteQueries;
use Illuminate\Contracts\Support\Responsable;

class CreateResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * Render the view for add query modal
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        // Set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        // Render the form
        $html = view('landlord/settings/sections/executequeries/modals/add', compact('page'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#commonModalBody',
            'action' => 'replace',
            'value' => $html);

        // Show modal footer
        $jsondata['dom_visibility'][] = array('selector' => '#commonModalFooter', 'action' => 'show');

        // Ajax response
        return response()->json($jsondata);
    }
}
