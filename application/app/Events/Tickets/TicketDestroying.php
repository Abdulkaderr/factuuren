<?php

/** --------------------------------------------------------------------------------
 * Event fired before ticket deletion execution
 * Allows modules to perform cleanup or prevent deletion
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tickets;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketDestroying {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $ticket_ids;

    /**
     * Create a new event instance.
     * This event is fired before ticket deletion execution
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $ticket_ids  Array of ticket IDs to be deleted
     * @return void
     */
    public function __construct($request, $ticket_ids) {
        $this->request = $request;
        $this->ticket_ids = $ticket_ids;
    }
}
