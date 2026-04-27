<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [show] process for the notes
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Notes;
use Illuminate\Contracts\Support\Responsable;

class ShowResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //render the note content into the common modal body
        $html = view('pages/notes/components/modals/show-note', compact('note', 'attachments'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#commonModalBody',
            'action' => 'replace',
            'value' => $html);

        //set the modal title to the note title
        $jsondata['dom_html'][] = array(
            'selector' => '#commonModalTitle',
            'action' => 'replace',
            'value' => safestr($note['note_title']));

        //hide the modal footer (show view does not need submit/close buttons)
        $jsondata['dom_visibility'][] = array('selector' => '#commonModalFooter', 'action' => 'hide');

        //ajax response
        return response()->json($jsondata);

    }

}
