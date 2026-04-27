<?php

/** --------------------------------------------------------------------------------
 * Event fired after bulk project archiving operations
 * Allows modules to perform post-archiving actions or notifications
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectBulkArchived {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $archived_projects;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after all archiving operations, before response,
     * allowing modules to perform bulk post-archiving actions
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \Illuminate\Support\Collection  $archived_projects  Collection of archived project objects
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $archived_projects, $payload) {
        $this->request = $request;
        $this->archived_projects = $archived_projects;
        $this->payload = $payload;
    }
}
