<?php

/** --------------------------------------------------------------------------------
 * Event fired after reply creation and attachment processing, before response
 * Allows modules to save custom data after the ticket reply has been created
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tickets;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketReplyStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $ticket_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after reply creation and attachment processing, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $ticket_id  Parent ticket ID
     * @param  array  $payload  Response data array containing reply and ticket
     * @return void
     */
    public function __construct($request, $ticket_id, $payload) {
        $this->request = $request;
        $this->ticket_id = $ticket_id;
        $this->payload = $payload;
    }
}
