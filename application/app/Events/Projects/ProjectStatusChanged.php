<?php

/** --------------------------------------------------------------------------------
 * Event fired after project status update and automation
 * Allows modules to perform additional actions after status change
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectStatusChanged {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project;
    public $old_status;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after status update and automation, before response,
     * allowing modules to perform post-status-change actions
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \App\Models\Project  $project  Project model with updated status
     * @param  string  $old_status  Previous status value
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $project, $old_status, $payload) {
        $this->request = $request;
        $this->project = $project;
        $this->old_status = $old_status;
        $this->payload = $payload;
    }
}
