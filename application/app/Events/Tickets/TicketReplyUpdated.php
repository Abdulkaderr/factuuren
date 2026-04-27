<?php

/** --------------------------------------------------------------------------------
 * Event fired after reply update, before response
 * Allows modules to react to reply updates
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tickets;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketReplyUpdated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $ticketreply_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after reply update, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $ticketreply_id  Updated reply ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $ticketreply_id, $payload) {
        $this->request = $request;
        $this->ticketreply_id = $ticketreply_id;
        $this->payload = $payload;
    }
}
