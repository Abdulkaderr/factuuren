<?php

/** --------------------------------------------------------------------------------
 * Event fired after file upload and attachment creation, before response
 * Allows modules to extend the file attachment process
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Leads;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadFileAttached {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $attachment;
    public $lead_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after file upload and attachment creation, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  object  $attachment  Created attachment model object
     * @param  int  $lead_id  Parent lead ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $attachment, $lead_id, $payload) {
        $this->request = $request;
        $this->attachment = $attachment;
        $this->lead_id = $lead_id;
        $this->payload = $payload;
    }
}
