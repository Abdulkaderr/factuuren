<?php

/** --------------------------------------------------------------------------------
 * Event fired after all timers are stopped for a task
 * Allows modules to perform actions after timer operations are complete
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskTimerStoppedAll {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $task;
    public $task_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after all timers are stopped for a task,
     * allowing modules to perform actions after timer operations are complete
     *
     * @param  \Illuminate\Http\Request  $request  The original HTTP request
     * @param  \App\Models\Task  $task  Task model object
     * @param  int  $task_id  Task ID whose timers were stopped
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $task, $task_id, $payload) {
        $this->request = $request;
        $this->task = $task;
        $this->task_id = $task_id;
        $this->payload = $payload;
    }
}
