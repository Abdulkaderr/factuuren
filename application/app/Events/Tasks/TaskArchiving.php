<?php

/** --------------------------------------------------------------------------------
 * Event fired before task archiving
 * Allows modules to validate or prevent task archival
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskArchiving {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $task_id;

    /**
     * Create a new event instance.
     * This event is fired before changing task state,
     * allowing modules to validate or prevent task archival
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  string  $task_id  Task ID to be archived
     * @return void
     */
    public function __construct($request, $task_id) {
        $this->request = $request;
        $this->task_id = $task_id;
    }
}
