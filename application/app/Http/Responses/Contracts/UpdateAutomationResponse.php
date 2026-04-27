<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [update automation] process for the contracts
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Contracts;
use Illuminate\Contracts\Support\Responsable;

class UpdateAutomationResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for contracts automation update
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        if (request('ref') == 'list') {
            $html = view('pages/contracts/components/table/ajax', compact('contracts', 'page'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => "#contract_" . $contract->doc_id,
                'action' => 'replace-with',
                'value' => $html);
        }

        if ($contract->contract_automation_status == 'enabled') {
            $jsondata['dom_visibility'][] = [
                'selector' => '#contract-automation-icon',
                'action' => 'show',
            ];
        } else {
            $jsondata['dom_visibility'][] = [
                'selector' => '#contract-automation-icon',
                'action' => 'hide',
            ];
        }

        //close modals
        $jsondata['dom_visibility'][] = array('selector' => '#commonModal', 'action' => 'close-modal');

        //notification
        $jsondata['notification'] = [
            'type' => 'success',
            'value' => __('lang.request_has_been_completed'),
        ];

        //ajax response
        return response()->json($jsondata);
    }

}
