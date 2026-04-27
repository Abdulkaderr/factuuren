<?php

/** --------------------------------------------------------------------------------
 * Event fired after lead creation, before response
 * Allows modules to save their custom data after the lead has been created
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Leads;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $lead;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after lead creation, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  object  $lead  Created lead model object
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $lead, $payload) {
        $this->request = $request;
        $this->lead = $lead;
        $this->payload = $payload;
    }
}
