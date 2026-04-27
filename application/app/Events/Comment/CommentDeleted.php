<?php

/** --------------------------------------------------------------------------------
 * Event fired after comment deletion, before response
 * Allows modules to perform cleanup or related actions after comment is removed
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Comment;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentDeleted {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $comment_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after comment deletion, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
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
