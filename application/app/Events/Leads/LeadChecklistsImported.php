<?php

/** --------------------------------------------------------------------------------
 * Event fired after checklist import, before response
 * Allows modules to extend the checklist import process
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Leads;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadChecklistsImported {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $lead_id;
    public $imported_count;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after checklist import, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $lead_id  Lead ID
     * @param  int  $imported_count  Number of checklists imported
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $lead_id, $imported_count, $payload) {
        $this->request = $request;
        $this->lead_id = $lead_id;
        $this->imported_count = $imported_count;
        $this->payload = $payload;
    }
}
