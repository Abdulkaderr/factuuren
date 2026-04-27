<?php

/** --------------------------------------------------------------------------------
 * Event fired before comment deletion
 * Allows modules to perform pre-action logic before comment is deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Checklists;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChecklistCommentDeleting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $comment_id;

    /**
     * Create a new event instance.
     * This event is fired before comment deletion
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $comment_id  Comment ID
     * @return void
     */
    public function __construct($request, $comment_id) {
        $this->request = $request;
        $this->comment_id = $comment_id;
    }
}
