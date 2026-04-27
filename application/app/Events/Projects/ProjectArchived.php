<?php

/** --------------------------------------------------------------------------------
 * Event fired after project archiving
 * Allows modules to perform post-archiving actions or notifications
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectArchived {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after project state change to archived, before response,
     * allowing modules to perform post-archiving actions
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \App\Models\Project  $project  Project model after archiving
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $project, $payload) {
        $this->request = $request;
        $this->project = $project;
        $this->payload = $payload;
    }
}
