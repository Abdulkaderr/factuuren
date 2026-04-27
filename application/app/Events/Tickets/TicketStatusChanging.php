<?php

/** --------------------------------------------------------------------------------
 * Event fired before bulk status change execution
 * Allows modules to validate or prevent status changes
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tickets;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketStatusChanging {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $ticket_ids;

    /**
     * Create a new event instance.
     * This event is fired before bulk status change execution
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $ticket_ids  Array of ticket IDs to be updated
     * @return void
     */
    public function __construct($request, $ticket_ids) {
        $this->request = $request;
        $this->ticket_ids = $ticket_ids;
    }
}
