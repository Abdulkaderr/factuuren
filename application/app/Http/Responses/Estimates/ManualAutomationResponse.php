<?php

/** --------------------------------------------------------------------------------
 * This class renders the response for the manualAutomation and manualAutomationAction
 * controller methods
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Estimates;

use Illuminate\Contracts\Support\Responsable;

class ManualAutomationResponse implements Responsable {

    private $payload;

    public function __construct($payload = []) {
        $this->payload = $payload;
    }

    /**
     * Render the response for manual automation
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all payload values as local variables
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //manualAutomation() - show the automation form in the modal
        if (!empty($this->payload)) {

            //set config flag so the blade shows the manual-run section
            config(['visibility.manual_automation' => true]);

            //render the existing automation form
            $html = view('pages/estimates/components/modals/automation', compact('page', 'estimate', 'automation', 'assigned'))->render();
            $jsondata['dom_html'][] = [
                'selector' => '#commonModalBody',
                'action'   => 'replace',
                'value'    => $html,
            ];

            //hide the default modal footer
            $jsondata['dom_visibility'][] = [
                'selector' => '#commonModalFooter',
                'action'   => 'hide',
            ];

            //initialise select2 and other js widgets inside the modal
            $jsondata['postrun_functions'][] = [
                'value' => 'NXEstimateEditAutomation',
            ];
        }

        //manualAutomationAction() - show success notification and close the modal
        if (empty($this->payload)) {

            $jsondata['notification'] = [
                'type'  => 'success',
                'value' => __('lang.request_has_been_completed'),
            ];

            $jsondata['dom_visibility'][] = [
                'selector' => '#commonModal',
                'action'   => 'close-modal',
            ];
        }

        return response()->json($jsondata);
    }
}
