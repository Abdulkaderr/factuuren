<?php

/** --------------------------------------------------------------------------------
 * Event fired after checklist update, before response
 * Allows modules to extend the checklist update process
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Leads;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadChecklistUpdated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $checklist;
    public $lead_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after checklist update, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  object  $checklist  Checklist model object
     * @param  int  $lead_id  Parent lead ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $checklist, $lead_id, $payload) {
        $this->request = $request;
        $this->checklist = $checklist;
        $this->lead_id = $lead_id;
        $this->payload = $payload;
    }
}
