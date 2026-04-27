<?php

/** --------------------------------------------------------------------------------
 * Event fired before project deletion operations
 * Allows modules to perform cleanup or validation before projects are deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectDeleting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project_ids;

    /**
     * Create a new event instance.
     * This event is fired before any deletion operations,
     * allowing modules to perform cleanup or prevent deletion
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $project_ids  Array of project IDs to be deleted
     * @return void
     */
    public function __construct($request, $project_ids) {
        $this->request = $request;
        $this->project_ids = $project_ids;
    }
}
