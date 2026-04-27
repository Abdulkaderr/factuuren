<?php

/** --------------------------------------------------------------------------------
 * Event fired after lead archival, before response
 * Allows modules to extend the lead archival process
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Leads;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadArchived {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $lead;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after lead archival, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  object  $lead  Archived lead model object
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $lead, $payload) {
        $this->request = $request;
        $this->lead = $lead;
        $this->payload = $payload;
    }
}
