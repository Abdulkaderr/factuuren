<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [edit] process for the files
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Files;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for files
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //fire event
        event(new \App\Events\Files\Responses\FileEdit($request, $this->payload));

        //[events] process module injections - push content to blade stacks
        if (isset($this->payload['module_injections'])) {
            foreach ($this->payload['module_injections'] as $injection) {
                try {
                    view()->startPush($injection['stack']);
                    echo $injection['content'];
                    view()->stopPush();
                } catch (Exception $e) {
                    //nothing
                }
            }
        }

        //page
        $html = view('pages/files/components/actions/rename', compact('payload'))->render();
        $jsondata['dom_html'][] = [
            'selector' => '#actionsModalBody',
            'action' => 'replace',
            'value' => $html,
        ];

        $jsondata['dom_visibility'][] = [
            'selector' => '#actionsModalFooter',
            'action' => 'show',
        ];

        //render
        return response()->json($jsondata);
    }
}
