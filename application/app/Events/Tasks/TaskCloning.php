<?php

/** --------------------------------------------------------------------------------
 * Event fired before task cloning
 * Allows modules to validate or modify clone parameters
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskCloning {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $source_task_id;

    /**
     * Create a new event instance.
     * This event is fired before cloning operations begin,
     * allowing modules to validate or modify clone parameters
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  string  $source_task_id  ID of task being cloned
     * @return void
     */
    public function __construct($request, $source_task_id) {
        $this->request = $request;
        $this->source_task_id = $source_task_id;
    }
}
