<?php

/** --------------------------------------------------------------------------------
 * This class renders the response for the [show] process for execute queries
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Landlord\Settings\ExecuteQueries;
use Illuminate\Contracts\Support\Responsable;

class ShowResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * Render the view for logs modal
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        // Set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        // Render logs view
        $html = view('landlord/settings/sections/executequeries/modals/view', compact('query', 'logs', 'filter'))->render();

        $jsondata['dom_html'][] = [
            'selector' => '#commonModalBody',
            'action' => 'replace',
            'value' => $html,
        ];

        // Hide modal footer
        $jsondata['dom_visibility'][] = [
            'selector' => '#commonModalFooter',
            'action' => 'hide',
        ];

        // Ajax response
        return response()->json($jsondata);
    }
}
