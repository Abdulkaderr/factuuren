<?php

/** --------------------------------------------------------------------------------
 * Event fired before user assignment changes
 * Allows modules to perform validation before assignments are updated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectAssignmentChanging {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project;
    public $current_assignments;
    public $new_assignments;

    /**
     * Create a new event instance.
     * This event is fired before user assignment changes,
     * allowing modules to perform validation or preparation
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  \App\Models\Project  $project  Project model object
     * @param  array  $current_assignments  Array of currently assigned user IDs
     * @param  array  $new_assignments  Array of new assigned user IDs
     * @return void
     */
    public function __construct($request, $project, $current_assignments, $new_assignments) {
        $this->request = $request;
        $this->project = $project;
        $this->current_assignments = $current_assignments;
        $this->new_assignments = $new_assignments;
    }
}
