<?php

/** --------------------------------------------------------------------------------
 * This class renders the response for the [create] process for the Refunds controller
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Refunds;

use Illuminate\Contracts\Support\Responsable;

class CreateResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * Render the add refund form into the common modal
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //unpack payload into local variables
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //render modal form
        $html = view('pages/refunds/components/modals/add-edit-inc', compact('page', 'payment'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#commonModalBody',
            'action'   => 'replace',
            'value'    => $html);

        //show modal footer
        $jsondata['dom_visibility'][] = array('selector' => '#commonModalFooter', 'action' => 'show');

        return response()->json($jsondata);
    }
}
