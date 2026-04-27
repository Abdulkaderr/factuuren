<?php

/** --------------------------------------------------------------------------------
 * Event fired after checklist position updates, before response
 * Allows modules to extend the checklist position update process
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Leads;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadChecklistPositionsUpdated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $checklist_ids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after checklist position updates, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  array  $checklist_ids  Array of reordered checklist IDs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $checklist_ids, $payload) {
        $this->request = $request;
        $this->checklist_ids = $checklist_ids;
        $this->payload = $payload;
    }
}
