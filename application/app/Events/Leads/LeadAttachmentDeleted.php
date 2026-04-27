<?php

/** --------------------------------------------------------------------------------
 * Event fired after attachment deletion, before response
 * Allows modules to extend the attachment deletion process
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Leads;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadAttachmentDeleted {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $attachment_id;
    public $lead_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after attachment deletion, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $attachment_id  Deleted attachment ID
     * @param  int  $lead_id  Parent lead ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $attachment_id, $lead_id, $payload) {
        $this->request = $request;
        $this->attachment_id = $attachment_id;
        $this->lead_id = $lead_id;
        $this->payload = $payload;
    }
}
