<?php

/** --------------------------------------------------------------------------------
 * Event fired after reply deletion, before response
 * Allows modules to perform cleanup or logging after deletion
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tickets;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketReplyDeleted {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $ticketreply_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after reply deletion, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $ticketreply_id  Deleted reply ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $ticketreply_id, $payload) {
        $this->request = $request;
        $this->ticketreply_id = $ticketreply_id;
        $this->payload = $payload;
    }
}
