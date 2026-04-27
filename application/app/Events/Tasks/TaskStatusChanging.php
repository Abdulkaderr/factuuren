<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation but before task status update
 * Allows modules to perform custom validation or modify status change
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskStatusChanging {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $task;

    /**
     * Create a new event instance.
     * This event is fired after validation but before status update,
     * allowing modules to perform custom validation or modify status change
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  \App\Models\Task  $task  Task model with current status
     * @return void
     */
    public function __construct($request, $task) {
        $this->request = $request;
        $this->task = $task;
    }
}
