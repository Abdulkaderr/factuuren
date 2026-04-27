<?php

/** --------------------------------------------------------------------------------
 * Event fired after comment deletion, before response
 * Allows modules to extend the comment deletion process
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Leads;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadCommentDeleted {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $comment_id;
    public $lead_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after comment deletion, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $comment_id  Deleted comment ID
     * @param  int  $lead_id  Parent lead ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $comment_id, $lead_id, $payload) {
        $this->request = $request;
        $this->comment_id = $comment_id;
        $this->lead_id = $lead_id;
        $this->payload = $payload;
    }
}
