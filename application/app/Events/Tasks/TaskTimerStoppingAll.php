<?php

/** --------------------------------------------------------------------------------
 * Event fired before stopping all timers for a task
 * Allows modules to perform actions before timer operations
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskTimerStoppingAll {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $task_id;

    /**
     * Create a new event instance.
     * This event is fired before stopping all timers for a task,
     * allowing modules to perform actions before timer operations
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request object
     * @param  int  $task_id  Task ID whose timers will be stopped
     * @return void
     */
    public function __construct($request, $task_id) {
        $this->request = $request;
        $this->task_id = $task_id;
    }
}
