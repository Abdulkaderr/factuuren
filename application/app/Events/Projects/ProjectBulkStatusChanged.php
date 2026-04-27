<?php

/** --------------------------------------------------------------------------------
 * Event fired after all status updates and automation
 * Allows modules to perform post-status-change actions
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectBulkStatusChanged {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $updated_projects;
    public $status_changes;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after all status updates and automation, before response,
     * allowing modules to perform post-status-change actions
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \Illuminate\Support\Collection  $updated_projects  Collection of updated project objects
     * @param  array  $status_changes  Array of old/new status pairs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $updated_projects, $status_changes, $payload) {
        $this->request = $request;
        $this->updated_projects = $updated_projects;
        $this->status_changes = $status_changes;
        $this->payload = $payload;
    }
}
