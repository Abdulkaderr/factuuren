<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [index] process for the fooo
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Items\Tasks;

use Illuminate\Contracts\Support\Responsable;

class TasksIndexResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for fooo members
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
        event(new \App\Events\Items\Responses\ItemTaskIndex($request, $this->payload));

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

        //render the view and save to json
        $html = view('pages/itemtasks/table/table', compact('page', 'tasks'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#products-tasks-side-panel-content',
            'action' => 'replace',
            'value' => $html,
        );

        //for creating tasks
        if (isset($action) && $action == 'create-edit-task') {

            $jsondata['dom_visibility'][] = [
                'selector' => '#commonModal',
                'action' => 'close-modal',
            ];

            $jsondata['notification'] = [
                'type' => 'success',
                'value' => __('lang.request_has_been_completed'),
            ];
        }

        //ajax response
        return response()->json($jsondata);
    }
}
