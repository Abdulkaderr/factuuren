<?php

/** --------------------------------------------------------------------------------
 * Event fired before lead deletion operations
 * Allows modules to perform pre-deletion logic
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Leads;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadDeleting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $lead_ids;

    /**
     * Create a new event instance.
     * This event is fired before deletion operations
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $lead_ids  Array of lead IDs to be deleted
     * @return void
     */
    public function __construct($request, $lead_ids) {
        $this->request = $request;
        $this->lead_ids = $lead_ids;
    }
}
