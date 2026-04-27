<?php

/** --------------------------------------------------------------------------------
 * Event fired after checklist deletion, before response
 * Allows modules to extend the checklist deletion process
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Leads;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadChecklistDeleted {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $checklist_id;
    public $lead_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after checklist deletion, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $checklist_id  Deleted checklist ID
     * @param  int  $lead_id  Parent lead ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $checklist_id, $lead_id, $payload) {
        $this->request = $request;
        $this->checklist_id = $checklist_id;
        $this->lead_id = $lead_id;
        $this->payload = $payload;
    }
}
