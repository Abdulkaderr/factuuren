<?php

/** --------------------------------------------------------------------------------
 * Event fired after log entry update, before response
 * Allows modules to extend the log update process
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Leads;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadLogUpdated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $log;
    public $lead_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after log entry update, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  object  $log  Updated log model object
     * @param  int  $lead_id  Parent lead ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $log, $lead_id, $payload) {
        $this->request = $request;
        $this->log = $log;
        $this->lead_id = $lead_id;
        $this->payload = $payload;
    }
}
