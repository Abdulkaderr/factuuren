<?php

/** --------------------------------------------------------------------------------
 * Event fired after bulk project progress updates
 * Allows modules to perform actions after progress changes are completed
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectBulkProgressChanged {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project_ids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after all progress updates,
     * allowing modules to perform actions after bulk progress changes are completed
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  array  $project_ids  Array of updated project IDs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $project_ids, $payload) {
        $this->request = $request;
        $this->project_ids = $project_ids;
        $this->payload = $payload;
    }
}
