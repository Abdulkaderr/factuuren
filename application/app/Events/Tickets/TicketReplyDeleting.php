<?php

/** --------------------------------------------------------------------------------
 * Event fired before reply deletion execution
 * Allows modules to perform cleanup or prevent deletion
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tickets;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketReplyDeleting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $ticketreply_id;

    /**
     * Create a new event instance.
     * This event is fired before reply deletion execution
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $ticketreply_id  Reply ID to be deleted
     * @return void
     */
    public function __construct($request, $ticketreply_id) {
        $this->request = $request;
        $this->ticketreply_id = $ticketreply_id;
    }
}
