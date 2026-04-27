<?php

/** --------------------------------------------------------------------------------
 * Renders the create-tasks modal for the Estimates controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Estimates;

use Illuminate\Contracts\Support\Responsable;

class CreateTasksResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the create tasks modal
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all payload data to local variables
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //render the modal html
        $html = view('pages/bill/components/modals/create-tasks',
            compact('estimate', 'lineitems', 'statuses', 'milestones', 'team_users', 'has_project', 'converted_lineitem_ids', 'disabled_lineitem_count'))->render();

        $jsondata['dom_html'][] = [
            'selector' => '#commonModalBody',
            'action'   => 'replace',
            'value'    => $html,
        ];

        return response()->json($jsondata);
    }
}
