<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before comment creation
 * Allows modules to perform pre-action logic before comment is stored
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Comment;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentStoring {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;

    /**
     * Create a new event instance.
     * This event is fired after validation, before comment creation
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @return void
     */
    public function __construct($request) {
        $this->request = $request;
    }
}
