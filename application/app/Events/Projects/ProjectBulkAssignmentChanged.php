<?php

/** --------------------------------------------------------------------------------
 * Event fired after bulk assignment updates complete
 * Allows modules to perform batch external system updates or manage workload distribution
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectBulkAssignmentChanged {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $updated_projects;
    public $assignment_changes;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after all assignment updates complete,
     * allowing modules to perform batch external system updates or manage workload distribution
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \Illuminate\Support\Collection  $updated_projects  Collection of updated project objects
     * @param  array  $assignment_changes  Array of assignment change details
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $updated_projects, $assignment_changes, $payload) {
        $this->request = $request;
        $this->updated_projects = $updated_projects;
        $this->assignment_changes = $assignment_changes;
        $this->payload = $payload;
    }
}
