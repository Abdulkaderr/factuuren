<?php

/** --------------------------------------------------------------------------------
 * Event fired after comment deletion, before response
 * Allows modules to perform cleanup after the comment has been deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Checklists;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChecklistCommentDeleted {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $comment_id;

    /**
     * Create a new event instance.
     * This event is fired after comment deletion, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $comment_id  Deleted comment ID
     * @return void
     */
    public function __construct($request, $comment_id) {
        $this->request = $request;
        $this->comment_id = $comment_id;
    }
}
