<?php

/** --------------------------------------------------------------------------------
 * This class renders the response for the [showHistory] process for the tickets
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Tickets;

use Illuminate\Contracts\Support\Responsable;

class ShowHistoryResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * Render the ticket history side panel response
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //response identifier
        config(['response.history' => true]);

        //[load more] - append additional history rows only
        if (request('action') == 'load') {

            $html = view('pages/ticket/components/misc/history-side-panel-rows', compact('history_tickets', 'ticket'))->render();
            $jsondata['dom_html'][] = [
                'selector' => '#ticket-history-list',
                'action'   => 'append',
                'value'    => $html,
            ];

        } else {

            //[initial load] - render the full panel content
            $html = view('pages/ticket/components/misc/history-side-panel', compact('ticket', 'history_tickets'))->render();
            $jsondata['dom_html'][] = [
                'selector' => '#sidepanel-ticket-history-body',
                'action'   => 'replace',
                'value'    => $html,
            ];
        }

        //update or hide the load more button
        if ($history_tickets->currentPage() < $history_tickets->lastPage()) {
            $next_page = $history_tickets->currentPage() + 1;
            $jsondata['dom_attributes'][] = [
                'selector' => '#ticket-history-load-more',
                'attr'     => 'data-url',
                'value'    => url('tickets/' . $ticket->ticket_id . '/history?action=load&page=' . $next_page),
            ];
            $jsondata['dom_visibility'][] = [
                'selector' => '#ticket-history-load-more-container',
                'action'   => 'show',
            ];
        } else {
            $jsondata['dom_visibility'][] = [
                'selector' => '#ticket-history-load-more-container',
                'action'   => 'hide',
            ];
        }

        //ajax response
        return response()->json($jsondata);
    }
}
