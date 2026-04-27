<?php

/** --------------------------------------------------------------------------------
 * Event fired after successful project creation
 * Allows modules to save their custom data after the project has been created
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after successful project creation,
     * allowing modules to save their custom data related to the project
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \App\Models\Project  $project  Created project model object
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $project, $payload) {
        $this->request = $request;
        $this->project = $project;
        $this->payload = $payload;
    }
}
