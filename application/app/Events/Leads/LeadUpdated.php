<?php

/** --------------------------------------------------------------------------------
 * Event fired after lead update, before response
 * Allows modules to save their custom data after the lead has been updated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Leads;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadUpdated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $lead;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after lead update, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  object  $lead  Updated lead model object
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $lead, $payload) {
        $this->request = $request;
        $this->lead = $lead;
        $this->payload = $payload;
    }
}
