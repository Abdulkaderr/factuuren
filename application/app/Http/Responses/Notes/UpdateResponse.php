<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [update] process for the notes
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Notes;
use Illuminate\Contracts\Support\Responsable;

class UpdateResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for notes
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //saved from the quick-edit button inside the show modal - return to show view
        if (request('ref') == 'show-modal') {

            $note = $notes->first();

            //re-render the note show view into the modal body
            $html = view('pages/notes/components/modals/show-note', compact('note', 'attachments'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => '#commonModalBody',
                'action' => 'replace',
                'value' => $html);

            //restore the note title in the modal header
            $jsondata['dom_html'][] = array(
                'selector' => '#commonModalTitle',
                'action' => 'replace',
                'value' => safestr($note->note_title));

            //hide the footer (no submit button needed in show view)
            $jsondata['dom_visibility'][] = array('selector' => '#commonModalFooter', 'action' => 'hide');

        } else {

            //close modal (default behaviour)
            $jsondata['dom_visibility'][] = array('selector' => '#commonModal', 'action' => 'close-modal');

        }

        //replace the row of this record in the background table
        $html = view('pages/notes/components/table/ajax', compact('notes'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => "#note_" . $notes->first()->note_id,
            'action' => 'replace-with',
            'value' => $html);

        //notice
        $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));

        //response
        return response()->json($jsondata);

    }

}
