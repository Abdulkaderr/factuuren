<?php

/** --------------------------------------------------------------------------------
 * Event fired before bulk project restoration operations
 * Allows modules to perform validation before projects are restored
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectBulkRestoring {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project_ids;

    /**
     * Create a new event instance.
     * This event is fired before any restoration operations,
     * allowing modules to perform bulk validation or preparation
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $project_ids  Array of project IDs to restore
     * @return void
     */
    public function __construct($request, $project_ids) {
        $this->request = $request;
        $this->project_ids = $project_ids;
    }
}
