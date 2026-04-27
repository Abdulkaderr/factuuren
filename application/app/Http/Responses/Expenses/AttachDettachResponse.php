<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [attach] process for the expenses
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Expenses;

use Illuminate\Contracts\Support\Responsable;

class AttachDettachResponse implements Responsable {

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

        //fire event
        event(new \App\Events\Expenses\Responses\ExpenseAttachDetach($request, $this->payload));

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

        //render the form
        $html = view('pages/expenses/components/actions/attach-dettach', compact('expense'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#actionsModalBody',
            'action' => 'replace',
            'value' => $html,
        );

        //show modal expenseter
        $jsondata['dom_visibility'][] = array('selector' => '#actionsModalFooter', 'action' => 'show');

        //ajax response
        return response()->json($jsondata);
    }
}
