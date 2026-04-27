<?php

/** --------------------------------------------------------------------------------
 * Event fired after successful project update
 * Allows modules to save their custom data after the project has been updated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectUpdated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after successful project update,
     * allowing modules to save their custom data related to the project
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \App\Models\Project  $project  Updated project model object
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $project, $payload) {
        $this->request = $request;
        $this->project = $project;
        $this->payload = $payload;
    }
}
