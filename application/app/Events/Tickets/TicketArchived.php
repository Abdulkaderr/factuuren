<?php

/** --------------------------------------------------------------------------------
 * Event fired after archiving tickets, before response
 * Allows modules to react to ticket archival
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tickets;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketArchived {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $ticket_ids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after archiving tickets, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  array  $ticket_ids  Array of archived ticket IDs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $ticket_ids, $payload) {
        $this->request = $request;
        $this->ticket_ids = $ticket_ids;
        $this->payload = $payload;
    }
}
