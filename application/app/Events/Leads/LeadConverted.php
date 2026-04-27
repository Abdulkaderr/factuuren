<?php

/** --------------------------------------------------------------------------------
 * Event fired after client creation and lead conversion, before response
 * Allows modules to extend the lead conversion process
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Leads;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadConverted {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $lead;
    public $client_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after client creation and lead conversion, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  object  $lead  Lead model object (converted state)
     * @param  int  $client_id  Created client ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $lead, $client_id, $payload) {
        $this->request = $request;
        $this->lead = $lead;
        $this->client_id = $client_id;
        $this->payload = $payload;
    }
}
