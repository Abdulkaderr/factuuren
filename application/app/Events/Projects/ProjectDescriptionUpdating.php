<?php

/** --------------------------------------------------------------------------------
 * Event fired before project description and tags update
 * Allows modules to perform validation or modifications before description changes
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectDescriptionUpdating {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project;

    /**
     * Create a new event instance.
     * This event is fired before description and tags update,
     * allowing modules to perform validation or modifications before changes
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  \App\Models\Project  $project  Project model with current description
     * @return void
     */
    public function __construct($request, $project) {
        $this->request = $request;
        $this->project = $project;
    }
}
