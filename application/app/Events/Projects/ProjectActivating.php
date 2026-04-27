<?php

/** --------------------------------------------------------------------------------
 * Event fired before project activation
 * Allows modules to perform validation before project is reactivated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectActivating {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project;

    /**
     * Create a new event instance.
     * This event is fired before changing project state to active,
     * allowing modules to perform validation or preparation
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  \App\Models\Project  $project  Project model before activation
     * @return void
     */
    public function __construct($request, $project) {
        $this->request = $request;
        $this->project = $project;
    }
}
