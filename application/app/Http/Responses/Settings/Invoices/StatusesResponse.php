<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [status] process for the invoices settings
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Settings\Invoices;
use Illuminate\Contracts\Support\Responsable;

class StatusesResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for statuses
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        $html = view('pages/settings/sections/invoices/statuses/page', compact('page', 'statuses'))->render();

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
            $jsondata['dom_attributes'][] = [
                'selector' => '#settings-menu-invoices',
                'attr' => 'aria-expanded',
                'value' => false,
            ];
            $jsondata['dom_action'][] = [
                'selector' => '#settings-menu-invoices',
                'action' => 'trigger',
                'value' => 'click',
            ];
            $jsondata['dom_classes'][] = [
                'selector' => '#settings-menu-invoices-statuses',
                'action' => 'add',
                'value' => 'active',
            ];
        }

        // POSTRUN FUNCTIONS------
        $jsondata['postrun_functions'][] = [
            'value' => 'NXSettingsInvoiceDragDrop',
        ];

        //ajax response
        return response()->json($jsondata);
    }
}
