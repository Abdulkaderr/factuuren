<?php

/** --------------------------------------------------------------------------------
 * This class renders the response for the [editTags] and [updateTags] processes
 * for the proposals controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Proposals;

use Illuminate\Contracts\Support\Responsable;

class EditTagsResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for proposals edit tags
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //show the form
        if ($response == 'edit') {

            $html = view('pages/proposals/components/modals/edit-tags', compact('tags', 'proposal'))->render();
            $jsondata['dom_html'][] = [
                'selector' => '#commonModalBody',
                'action' => 'replace',
                'value' => $html,
            ];
            return response()->json($jsondata);
        }

        //action response
        if ($response == 'update') {

            //close modal
            $jsondata['dom_visibility'][] = [
                'selector' => '#commonModal',
                'action' => 'close-modal',
            ];

            //success notification
            $jsondata['notification'] = [
                'type' => 'success',
                'value' => __('lang.request_has_been_completed'),
            ];

            //replace the table row
            $html = view('pages/proposals/components/table/ajax', compact('tags', 'proposals'))->render();
            $jsondata['dom_html'][] = [
                'selector' => "#proposal_$id",
                'action' => 'replace-with',
                'value' => $html,
            ];

            return response()->json($jsondata);
        }
    }
}
