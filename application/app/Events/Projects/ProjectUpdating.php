<?php

/** --------------------------------------------------------------------------------
 * Event fired after core request validation but before project update
 * Allows modules to perform manual validation on their custom fields
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectUpdating {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project;

    /**
     * Create a new event instance.
     * This event is fired after validation passes but before project update,
     * allowing modules to perform manual validation on their custom fields
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request with validated data
     * @param  \App\Models\Project  $project  Original project model state
     * @return void
     */
    public function __construct($request, $project) {
        $this->request = $request;
        $this->project = $project;
    }
}
