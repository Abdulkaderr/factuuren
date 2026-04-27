<?php

/** --------------------------------------------------------------------------------
 * Event fired before comment creation
 * Allows modules to validate or modify comment data before storage
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskCommentStoring {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $task_id;

    /**
     * Create a new event instance.
     * This event is fired after validation, before comment creation,
     * allowing modules to validate or modify comment data
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request with comment data
     * @param  string  $task_id  Task ID
     * @return void
     */
    public function __construct($request, $task_id) {
        $this->request = $request;
        $this->task_id = $task_id;
    }
}
