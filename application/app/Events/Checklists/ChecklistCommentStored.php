<?php

/** --------------------------------------------------------------------------------
 * Event fired after comment creation, before response
 * Allows modules to save their custom data after the comment has been created
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Checklists;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChecklistCommentStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $checklist_id;
    public $comment_id;

    /**
     * Create a new event instance.
     * This event is fired after comment creation, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $checklist_id  Checklist ID
     * @param  int  $comment_id  Created comment ID
     * @return void
     */
    public function __construct($request, $checklist_id, $comment_id) {
        $this->request = $request;
        $this->checklist_id = $checklist_id;
        $this->comment_id = $comment_id;
    }
}
