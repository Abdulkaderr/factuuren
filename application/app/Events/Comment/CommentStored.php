<?php

/** --------------------------------------------------------------------------------
 * Event fired after comment creation, before response
 * Allows modules to save their custom data after the comment has been created
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Comment;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $comment_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after comment creation, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $comment_id  Created comment ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $comment_id, $payload) {
        $this->request = $request;
        $this->comment_id = $comment_id;
        $this->payload = $payload;
    }
}
