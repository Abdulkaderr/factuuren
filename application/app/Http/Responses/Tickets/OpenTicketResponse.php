<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [openTicket] process for the tickets
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Tickets;
use Illuminate\Contracts\Support\Responsable;

class OpenTicketResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the response for open ticket
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        $jsondata = [];

        //called from the list page - replace the table row
        if (request('ref') == 'list') {
            foreach ($tickets as $ticket) {
                $html = view('pages/tickets/components/table/ajax-inc', compact('ticket'))->render();
                $jsondata['dom_html'][] = [
                    'selector' => '#ticket_' . $ticket->ticket_id,
                    'action'   => 'replace-with',
                    'value'    => $html,
                ];
            }
            //notice
            $jsondata['notification'] = [
                'type'  => 'success',
                'value' => __('lang.request_has_been_completed'),
            ];
        } else {
            //session
            request()->session()->flash('success-notification', __('lang.request_has_been_completed'));
            //redirect to tickets list
            $jsondata['redirect_url'] = url('tickets');
        }

        //response
        return response()->json($jsondata);
    }

}
