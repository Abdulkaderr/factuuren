<?php

/** --------------------------------------------------------------------------------
 * Event fired after lead cloning, before response
 * Allows modules to extend the lead cloning process
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Leads;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadCloned {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $source_lead;
    public $new_lead;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after lead cloning and optional checklist/file copying, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  object  $source_lead  Original lead model object
     * @param  object  $new_lead  Cloned lead model object
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $source_lead, $new_lead, $payload) {
        $this->request = $request;
        $this->source_lead = $source_lead;
        $this->new_lead = $new_lead;
        $this->payload = $payload;
    }
}
