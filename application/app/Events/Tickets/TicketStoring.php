<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before ticket creation
 * Allows modules to perform pre-action logic before ticket is stored
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tickets;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketStoring {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;

    /**
     * Create a new event instance.
     * This event is fired after validation, before ticket creation
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object with validated data
     * @return void
     */
    public function __construct($request) {
        $this->request = $request;
    }
}
