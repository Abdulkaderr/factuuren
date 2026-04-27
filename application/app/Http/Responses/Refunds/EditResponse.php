<?php

/** --------------------------------------------------------------------------------
 * This class renders the response for the [edit] process for the Refunds controller
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Refunds;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * Render the edit refund form into the common modal
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //unpack payload into local variables
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //render modal form (same template as create, page['response'] distinguishes)
        $html = view('pages/refunds/components/modals/add-edit-inc', compact('page', 'refund'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#commonModalBody',
            'action'   => 'replace',
            'value'    => $html);

        //show modal footer
        $jsondata['dom_visibility'][] = array('selector' => '#commonModalFooter', 'action' => 'show');

        return response()->json($jsondata);
    }
}
