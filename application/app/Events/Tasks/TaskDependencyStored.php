<?php

/** --------------------------------------------------------------------------------
 * Event fired after dependency creation
 * Allows modules to perform post-processing after dependency is created
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskDependencyStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $dependency;
    public $task_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after dependency creation, before response,
     * allowing modules to perform post-processing
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \App\Models\TaskDependency  $dependency  Created dependency model object
     * @param  string  $task_id  Main task ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $dependency, $task_id, $payload) {
        $this->request = $request;
        $this->dependency = $dependency;
        $this->task_id = $task_id;
        $this->payload = $payload;
    }
}
