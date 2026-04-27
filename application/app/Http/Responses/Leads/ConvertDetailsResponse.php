<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [convert] process for the leads
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Leads;

use Illuminate\Contracts\Support\Responsable;

class ConvertDetailsResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for team members
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //fire event to allow modules to extend view data
        event(new \App\Events\Leads\Responses\LeadConvertDetails($request, $this->payload));

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

        //update address details in the form
        $jsondata['dom_val'][] = [
            'selector' => '#convert_lead_firstname',
            'value' => $lead->lead_firstname,
        ];
        $jsondata['dom_val'][] = [
            'selector' => '#convert_lead_lastname',
            'value' => $lead->lead_lastname,
        ];
        $jsondata['dom_val'][] = [
            'selector' => '#convert_lead_street',
            'value' => $lead->lead_street,
        ];
        $jsondata['dom_val'][] = [
            'selector' => '#convert_lead_city',
            'value' => $lead->lead_city,
        ];
        $jsondata['dom_val'][] = [
            'selector' => '#convert_lead_state',
            'value' => $lead->lead_state,
        ];
        $jsondata['dom_val'][] = [
            'selector' => '#convert_lead_zip',
            'value' => $lead->lead_zip,
        ];
        $jsondata['dom_val'][] = [
            'selector' => '#convert_lead_street',
            'value' => $lead->lead_street,
        ];
        $jsondata['dom_action'][] = [
            'selector' => '#convert_lead_country',
            'action' => 'trigger-select-change',
            'value' => $lead->lead_country,
        ];
        $jsondata['dom_action'][] = [
            'selector' => '#convert_lead_website',
            'action' => 'trigger-select-change',
            'value' => $lead->lead_website,
        ];
        $jsondata['dom_classes'][] = [
            'selector' => '#leadConvertToCustomer',
            'action' => 'remove',
            'value' => 'overlay',
        ];

        //ajax response
        return response()->json($jsondata);
    }
}
