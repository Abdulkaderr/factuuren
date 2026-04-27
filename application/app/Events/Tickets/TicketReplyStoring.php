<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before reply creation
 * Allows modules to perform pre-action logic before ticket reply is stored
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tickets;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketReplyStoring {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $ticket_id;

    /**
     * Create a new event instance.
     * This event is fired after validation, before reply creation
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $ticket_id  Parent ticket ID
     * @return void
     */
    public function __construct($request, $ticket_id) {
        $this->request = $request;
        $this->ticket_id = $ticket_id;
    }
}
