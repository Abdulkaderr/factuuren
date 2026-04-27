<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [attach] process for the estimates
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Contracts;

use Illuminate\Contracts\Support\Responsable;

class AttachProjectResponse implements Responsable {

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

        //full payload array
        $payload = $this->payload;

        //fire event
        event(new \App\Events\Contracts\Responses\ContractAttachProject($request, $this->payload));

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
        if ($type == 'form') {
            $html = view('pages/contracts/components/actions/attach-project', compact('payload'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => '#actionsModalBody',
                'action' => 'replace',
                'value' => $html,
            );

            //show modal footer
            $jsondata['dom_visibility'][] = array('selector' => '#actionsModalFooter', 'action' => 'show');
        }

        //attach/detach completed
        if ($type == 'update') {

            //refresh the list
            if (request('ref') == 'list') {
                $html = view('pages/contracts/components/table/ajax', compact('contracts'))->render();
                $jsondata['dom_html'][] = array(
                    'selector' => "#contract_" . $contract->doc_id,
                    'action' => 'replace-with',
                    'value' => $html,
                );

                //close modals
                $jsondata['dom_visibility'][] = array('selector' => '#commonModal', 'action' => 'close-modal');
                $jsondata['dom_visibility'][] = array('selector' => '#actionsModal', 'action' => 'close-modal');
            } else {
                //refresh the contract page
                $jsondata['redirect_url'] = url('contracts/' . $contract->doc_id);
            }

            //notice
            $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));
        }

        //ajax response
        return response()->json($jsondata);
    }
}
