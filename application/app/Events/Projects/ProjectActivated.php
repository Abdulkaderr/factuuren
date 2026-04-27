<?php

/** --------------------------------------------------------------------------------
 * Event fired after project activation
 * Allows modules to restore external system connections or restart workflows
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectActivated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after project state change to active, before response,
     * allowing modules to restore external connections or restart workflows
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \App\Models\Project  $project  Project model after activation
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $project, $payload) {
        $this->request = $request;
        $this->project = $project;
        $this->payload = $payload;
    }
}
