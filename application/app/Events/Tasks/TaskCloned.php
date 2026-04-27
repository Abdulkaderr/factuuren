<?php

/** --------------------------------------------------------------------------------
 * Event fired after task cloning
 * Allows modules to perform post-processing after cloning
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskCloned {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $source_task;
    public $cloned_task;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after cloning completion, before response,
     * allowing modules to perform post-processing
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \App\Models\Task  $source_task  Original task model object
     * @param  \App\Models\Task  $cloned_task  New cloned task model object
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $source_task, $cloned_task, $payload) {
        $this->request = $request;
        $this->source_task = $source_task;
        $this->cloned_task = $cloned_task;
        $this->payload = $payload;
    }
}
