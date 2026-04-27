<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before lead update
 * Allows modules to perform pre-action logic before lead is updated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Leads;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadUpdating {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $lead;

    /**
     * Create a new event instance.
     * This event is fired after validation, before lead update
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  object  $lead  Lead model object (current state)
     * @return void
     */
    public function __construct($request, $lead) {
        $this->request = $request;
        $this->lead = $lead;
    }
}
