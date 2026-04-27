<?php

/** --------------------------------------------------------------------------------
 * Event fired before timer starts
 * Allows modules to validate or prevent timer start
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskTimerStarting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $task_id;

    /**
     * Create a new event instance.
     * This event is fired after permissions check, before timer creation,
     * allowing modules to validate or prevent timer start
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  string  $task_id  Task ID
     * @return void
     */
    public function __construct($request, $task_id) {
        $this->request = $request;
        $this->task_id = $task_id;
    }
}
