<?php

/** --------------------------------------------------------------------------------
 * Event fired after dependency deletion
 * Allows modules to perform post-processing after dependency is deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskDependencyDeleted {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $task_id;
    public $dependency_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after dependency deletion, before response,
     * allowing modules to perform post-processing
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  string  $task_id  Main task ID
     * @param  string  $dependency_id  Deleted dependency ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $task_id, $dependency_id, $payload) {
        $this->request = $request;
        $this->task_id = $task_id;
        $this->dependency_id = $dependency_id;
        $this->payload = $payload;
    }
}
