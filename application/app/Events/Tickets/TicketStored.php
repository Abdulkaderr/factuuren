<?php

/** --------------------------------------------------------------------------------
 * Event fired after ticket creation and attachment processing, before response
 * Allows modules to save their custom data after the ticket has been created
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tickets;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $ticket_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after ticket creation and attachment processing, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $ticket_id  Created ticket ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $ticket_id, $payload) {
        $this->request = $request;
        $this->ticket_id = $ticket_id;
        $this->payload = $payload;
    }
}
