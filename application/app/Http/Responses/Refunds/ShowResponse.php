<?php

/** --------------------------------------------------------------------------------
 * This class renders the response for the [show] (receipt) process for the Refunds controller
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Refunds;

use Illuminate\Contracts\Support\Responsable;

class ShowResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * Render the refund receipt view into the common modal body
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //unpack payload into local variables
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //render receipt modal content
        $html = view('pages/refunds/components/modals/show-receipt', compact('refund'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#plainModalBody',
            'action'   => 'replace',
            'value'    => $html);

        return response()->json($jsondata);
    }
}
