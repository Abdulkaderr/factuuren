<?php

/** --------------------------------------------------------------------------------
 * Event fired after task assignment changes and notifications
 * Allows modules to save custom data or perform post-processing
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskAssignmentChanged {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $task;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after task assignment changes and notifications,
     * allowing modules to save custom data or perform post-processing
     *
     * @param  \Illuminate\Http\Request  $request  The original HTTP request
     * @param  \App\Models\Task  $task  The updated task model object
     * @param  array  $payload  The response data array
     * @return void
     */
    public function __construct($request, $task, $payload) {
        $this->request = $request;
        $this->task = $task;
        $this->payload = $payload;
    }
}
