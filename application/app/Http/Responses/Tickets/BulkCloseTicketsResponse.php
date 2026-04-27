<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [bulkCloseTickets] process for the
 * tickets controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Tickets;
use Illuminate\Contracts\Support\Responsable;

class BulkCloseTicketsResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the response for bulk close tickets
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

        //replace each updated row in the table
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

        return response()->json($jsondata);
    }
}
