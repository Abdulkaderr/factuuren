<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation but before task assignment changes
 * Allows modules to perform custom validation or pre-processing
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskAssignmentChanging {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $task;

    /**
     * Create a new event instance.
     * This event is fired after validation but before task assignment changes,
     * allowing modules to perform custom validation or pre-processing
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request object
     * @param  \App\Models\Task  $task  The task model object
     * @return void
     */
    public function __construct($request, $task) {
        $this->request = $request;
        $this->task = $task;
    }
}
