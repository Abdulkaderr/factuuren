<?php

/** --------------------------------------------------------------------------------
 * Event fired after task activation
 * Allows modules to perform post-processing after activation
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskActivated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $task;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after task state change, before response,
     * allowing modules to perform post-processing
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \App\Models\Task  $task  Task model after activation
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $task, $payload) {
        $this->request = $request;
        $this->task = $task;
        $this->payload = $payload;
    }
}
