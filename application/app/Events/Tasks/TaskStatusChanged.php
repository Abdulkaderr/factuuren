<?php

/** --------------------------------------------------------------------------------
 * Event fired after successful task status update
 * Allows modules to perform post-status-change actions or notifications
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskStatusChanged {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $task;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after status update and dependency refresh,
     * allowing modules to perform post-status-change actions or notifications
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \App\Models\Task  $task  Task model with updated status
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $task, $payload) {
        $this->request = $request;
        $this->task = $task;
        $this->payload = $payload;
    }
}
