<?php

/** --------------------------------------------------------------------------------
 * Event fired before automation settings update
 * Allows modules to perform validation on automation settings
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectAutomationUpdating {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project;
    public $new_settings;

    /**
     * Create a new event instance.
     * This event is fired before automation settings update,
     * allowing modules to perform validation or modification
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  \App\Models\Project  $project  Project model with current automation settings
     * @param  array  $new_settings  Array of new automation settings
     * @return void
     */
    public function __construct($request, $project, $new_settings) {
        $this->request = $request;
        $this->project = $project;
        $this->new_settings = $new_settings;
    }
}
