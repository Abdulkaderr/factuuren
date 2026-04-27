<?php

/** --------------------------------------------------------------------------------
 * Event fired before bulk project archiving operations
 * Allows modules to perform cleanup or validation before projects are archived
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectBulkArchiving {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project_ids;

    /**
     * Create a new event instance.
     * This event is fired before any archiving operations,
     * allowing modules to perform bulk cleanup or validation
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $project_ids  Array of project IDs to archive
     * @return void
     */
    public function __construct($request, $project_ids) {
        $this->request = $request;
        $this->project_ids = $project_ids;
    }
}
