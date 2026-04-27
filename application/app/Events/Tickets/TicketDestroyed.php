<?php

/** --------------------------------------------------------------------------------
 * Event fired after ticket deletion, before response
 * Allows modules to perform cleanup or logging after deletion
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tickets;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketDestroyed {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $ticket_ids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after ticket deletion, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  array  $ticket_ids  Array of deleted ticket IDs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $ticket_ids, $payload) {
        $this->request = $request;
        $this->ticket_ids = $ticket_ids;
        $this->payload = $payload;
    }
}
