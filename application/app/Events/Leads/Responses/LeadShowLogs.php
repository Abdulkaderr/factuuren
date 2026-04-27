<?php

/** --------------------------------------------------------------------------------
 * Event fired when lead logs tab is being rendered
 * Allows modules to extend the view with additional data
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Leads\Responses;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadShowLogs {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired before the lead logs tab is rendered,
     * allowing modules to modify the payload data
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $payload  Reference to the view data array
     * @return void
     */
    public function __construct($request, &$payload) {
        $this->request = $request;
        $this->payload = &$payload;
    }
}
