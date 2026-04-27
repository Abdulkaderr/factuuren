<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before ticket update
 * Allows modules to perform pre-action logic before ticket is updated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tickets;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketUpdating {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $ticket_id;

    /**
     * Create a new event instance.
     * This event is fired after validation, before ticket update
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $ticket_id  Ticket ID being updated
     * @return void
     */
    public function __construct($request, $ticket_id) {
        $this->request = $request;
        $this->ticket_id = $ticket_id;
    }
}
