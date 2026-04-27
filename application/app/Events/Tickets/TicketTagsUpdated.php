<?php

/** --------------------------------------------------------------------------------
 * Event fired after tag update, before response
 * Allows modules to react to ticket tag changes
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tickets;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketTagsUpdated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $ticket_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after tag update, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $ticket_id  Ticket ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $ticket_id, $payload) {
        $this->request = $request;
        $this->ticket_id = $ticket_id;
        $this->payload = $payload;
    }
}
