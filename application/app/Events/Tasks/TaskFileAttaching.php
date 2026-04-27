<?php

/** --------------------------------------------------------------------------------
 * Event fired before file attachment
 * Allows modules to validate or modify file data before storage
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskFileAttaching {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $task_id;

    /**
     * Create a new event instance.
     * This event is fired after file validation, before file storage,
     * allowing modules to validate or modify file data
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request with file data
     * @param  string  $task_id  Task ID
     * @return void
     */
    public function __construct($request, $task_id) {
        $this->request = $request;
        $this->task_id = $task_id;
    }
}
