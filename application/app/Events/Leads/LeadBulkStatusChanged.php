<?php

/** --------------------------------------------------------------------------------
 * Event fired after bulk status updates, before response
 * Allows modules to extend the bulk status change process
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Leads;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadBulkStatusChanged {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $lead_ids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after bulk status updates, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  array  $lead_ids  Array of lead IDs with status changed
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $lead_ids, $payload) {
        $this->request = $request;
        $this->lead_ids = $lead_ids;
        $this->payload = $payload;
    }
}
