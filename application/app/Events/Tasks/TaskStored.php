<?php

/** --------------------------------------------------------------------------------
 * Event fired after successful task creation
 * Allows modules to save their custom data after the task has been created
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $task;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after successful task creation,
     * allowing modules to save their custom data related to the task
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \App\Models\Task  $task  Created task model object
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $task, $payload) {
        $this->request = $request;
        $this->task = $task;
        $this->payload = $payload;
    }
}
