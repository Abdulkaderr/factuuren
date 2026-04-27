<?php

/** --------------------------------------------------------------------------------
 * Event fired after bulk project restoration operations
 * Allows modules to restore connections or restart workflows for multiple projects
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectBulkRestored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $restored_projects;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after all restoration operations, before response,
     * allowing modules to restore external connections or restart workflows
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \Illuminate\Support\Collection  $restored_projects  Collection of restored project objects
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $restored_projects, $payload) {
        $this->request = $request;
        $this->restored_projects = $restored_projects;
        $this->payload = $payload;
    }
}
