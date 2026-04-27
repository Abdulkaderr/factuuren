<?php

/** --------------------------------------------------------------------------------
 * Event fired after checklist comment deletion, before response
 * Allows modules to extend the checklist comment deletion process
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Leads;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadChecklistCommentDeleted {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $comment_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after checklist comment deletion, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $comment_id  Deleted comment ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $comment_id, $payload) {
        $this->request = $request;
        $this->comment_id = $comment_id;
        $this->payload = $payload;
    }
}
