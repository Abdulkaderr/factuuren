<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [show] process for the tickets
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Tickets;

use Illuminate\Contracts\Support\Responsable;

class ChangeStatusResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view ticket
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
        event(new \App\Events\Tickets\Responses\TicketChangeStatus($request, $this->payload));

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

        $jsondata = [];

        //show form
        if ($action == 'show') {
            $html = view('pages/tickets/components/modals/change-status', compact('statuses'))->render();
            $jsondata['dom_html'][] = [
                'selector' => '#actionsModalBody',
                'action' => 'replace',
                'value' => $html,
            ];
        }

        //update statuses
        if ($action == 'update') {

            //called from the ticket show page
            if (request('source') == 'page') {
                request()->session()->flash('success-notification', __('lang.request_has_been_completed'));
                $jsondata['redirect_url'] = url('tickets/' . request('id'));
            } else {
                foreach ($tickets as $ticket) {
                    //replace row
                    $html = view('pages/tickets/components/table/ajax-inc', compact('ticket'))->render();
                    $jsondata['dom_html'][] = [
                        'selector' => '#ticket_' . $ticket->ticket_id,
                        'action' => 'replace-with',
                        'value' => $html,
                    ];
                }

                //close modal
                $jsondata['dom_visibility'][] = [
                    'selector' => '#actionsModal',
                    'action' => 'close-modal',
                ];

                //notice
                $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));
            }
        }

        //ajax response
        return response()->json($jsondata);
    }
}
