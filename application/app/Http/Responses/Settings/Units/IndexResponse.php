<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [index] process for the units settings
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Settings\Units;
use Illuminate\Contracts\Support\Responsable;

class IndexResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for units
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //for direct page load (not ajax)
        if (!request()->ajax()) {
            return view('pages/settings/wrapper', compact('page', 'units'))->render();
        }

        //for ajax requests (dynamic loading within settings)
        $html = view('pages/settings/sections/units/page', compact('page', 'units'))->render();

        $jsondata['dom_html'][] = array(
            'selector' => "#settings-wrapper",
            'action' => 'replace',
            'value' => $html);

        $jsondata['dom_move_element'][] = array(
            'element' => '#list-page-actions',
            'newparent' => '.parent-page-actions',
            'method' => 'replace',
            'visibility' => 'show');
        $jsondata['dom_visibility'][] = [
            'selector' => '#list-page-actions-container',
            'action' => 'show',
        ];

        //left menu activate
        if (request('url_type') == 'dynamic') {
            $jsondata['dom_classes'][] = [
                'selector' => '#settings-menu-units',
                'action' => 'add',
                'value' => 'active',
            ];
        }

        //ajax response
        return response()->json($jsondata);
    }
}