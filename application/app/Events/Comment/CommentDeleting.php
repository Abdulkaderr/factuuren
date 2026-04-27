<?php

/** --------------------------------------------------------------------------------
 * Event fired before comment deletion
 * Allows modules to perform pre-deletion logic before comment is removed
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Comment;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentDeleting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $comment_id;

    /**
     * Create a new event instance.
     * This event is fired before comment deletion
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $comment_id  Comment ID to be deleted
     * @return void
     */
    public function __construct($request, $comment_id) {
        $this->request = $request;
        $this->comment_id = $comment_id;
    }
}
