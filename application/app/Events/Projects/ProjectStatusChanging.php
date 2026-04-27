<?php

/** --------------------------------------------------------------------------------
 * Event fired before project status update
 * Allows modules to perform validation or additional processing before status change
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectStatusChanging {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project;
    public $new_status;

    /**
     * Create a new event instance.
     * This event is fired after validation, before status update,
     * allowing modules to perform additional validation or preprocessing
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  \App\Models\Project  $project  Project model with current status
     * @param  string  $new_status  New status value
     * @return void
     */
    public function __construct($request, $project, $new_status) {
        $this->request = $request;
        $this->project = $project;
        $this->new_status = $new_status;
    }
}
