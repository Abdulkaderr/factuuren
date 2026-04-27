<?php

/** --------------------------------------------------------------------------------
 * Event fired after project description and tags update
 * Allows modules to perform actions after description changes are completed
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectDescriptionUpdated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after description and tags update,
     * allowing modules to perform actions after description changes are completed
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \App\Models\Project  $project  Project model with updated description
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $project, $payload) {
        $this->request = $request;
        $this->project = $project;
        $this->payload = $payload;
    }
}
