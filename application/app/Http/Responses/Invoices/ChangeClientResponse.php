<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [changeClient] process for the invoices
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Invoices;

use Illuminate\Contracts\Support\Responsable;

class ChangeClientResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the change client form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //render the form
        $html = view('pages/bill/components/modals/change-client', compact('invoice'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#actionsModalBody',
            'action' => 'replace',
            'value' => $html);

        //show modal footer
        $jsondata['dom_visibility'][] = array('selector' => '#actionsModalFooter', 'action' => 'show');

        //response
        return response()->json($jsondata);
    }
}
