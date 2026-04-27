<?php

/** --------------------------------------------------------------------------------
 * Event fired after comment creation, before response
 * Allows modules to extend the comment creation process
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Leads;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadCommentStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $comment;
    public $lead_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after comment creation, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  object  $comment  Created comment model object
     * @param  int  $lead_id  Parent lead ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $comment, $lead_id, $payload) {
        $this->request = $request;
        $this->comment = $comment;
        $this->lead_id = $lead_id;
        $this->payload = $payload;
    }
}
