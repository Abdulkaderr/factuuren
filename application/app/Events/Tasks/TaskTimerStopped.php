<?php

/** --------------------------------------------------------------------------------
 * Event fired after timer stops
 * Allows modules to perform post-processing after timer stop
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskTimerStopped {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $task_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after timer stopping, before response,
     * allowing modules to perform post-processing
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  string  $task_id  Task ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $task_id, $payload) {
        $this->request = $request;
        $this->task_id = $task_id;
        $this->payload = $payload;
    }
}
