<?php

/** --------------------------------------------------------------------------------
 * Event fired before project archiving
 * Allows modules to perform cleanup or validation before project is archived
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectArchiving {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project;

    /**
     * Create a new event instance.
     * This event is fired before changing project state to archived,
     * allowing modules to perform cleanup or validation
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  \App\Models\Project  $project  Project model before archiving
     * @return void
     */
    public function __construct($request, $project) {
        $this->request = $request;
        $this->project = $project;
    }
}
