<?php

/** --------------------------------------------------------------------------------
 * Renders the response for the distraction free mode toggle on the task view
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\User;
use Illuminate\Contracts\Support\Responsable;

class CardsViewModeReposnse implements Responsable {

    private $payload;

    public function __construct($payload = []) {
        $this->payload = $payload;
    }

    /**
     * Toggle the distraction free mode buttons visibility
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all payload data to local variables
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //response identifier
        config(['response.show' => true]);

        $jsondata = [];

        //enable action — hide the enable button, show the disable button, add body class
        if ($action == 'enable') {
            $jsondata['dom_visibility'][] = [
                'selector' => '#task_distraction_free_enable_btn',
                'action' => 'hide',
            ];
            $jsondata['dom_visibility'][] = [
                'selector' => '#task_distraction_free_disable_btn',
                'action' => 'show',
            ];
            $jsondata['dom_classes'][] = [
                'selector' => '#main-body',
                'action' => 'add',
                'value' => 'kanban_card_distraction_free_mode',
            ];
        }

        //disable action — hide the disable button, show the enable button, remove body class
        if ($action == 'disable') {
            $jsondata['dom_visibility'][] = [
                'selector' => '#task_distraction_free_disable_btn',
                'action' => 'hide',
            ];
            $jsondata['dom_visibility'][] = [
                'selector' => '#task_distraction_free_enable_btn',
                'action' => 'show',
            ];
            $jsondata['dom_classes'][] = [
                'selector' => '#main-body',
                'action' => 'remove',
                'value' => 'kanban_card_distraction_free_mode',
            ];
        }

        return response()->json($jsondata);
    }
}
