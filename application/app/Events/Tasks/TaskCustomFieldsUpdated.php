<?php

/** --------------------------------------------------------------------------------
 * Event fired after custom fields update
 * Allows modules to perform post-processing after custom fields change
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskCustomFieldsUpdated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $task;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after custom fields update, before response,
     * allowing modules to perform post-processing
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \App\Models\Task  $task  Task model with updated custom fields
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $task, $payload) {
        $this->request = $request;
        $this->task = $task;
        $this->payload = $payload;
    }
}
