<?php

/** --------------------------------------------------------------------------------
 * Event fired after assignment changes and notifications
 * Allows modules to perform post-assignment actions
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectAssignmentChanged {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project;
    public $newly_assigned;
    public $removed_assignments;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after assignment changes and notifications, before response,
     * allowing modules to perform post-assignment actions
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \App\Models\Project  $project  Updated project model object
     * @param  array  $newly_assigned  Array of newly assigned user IDs
     * @param  array  $removed_assignments  Array of removed user IDs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $project, $newly_assigned, $removed_assignments, $payload) {
        $this->request = $request;
        $this->project = $project;
        $this->newly_assigned = $newly_assigned;
        $this->removed_assignments = $removed_assignments;
        $this->payload = $payload;
    }
}
