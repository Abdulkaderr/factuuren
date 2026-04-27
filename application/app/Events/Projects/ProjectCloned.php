<?php

/** --------------------------------------------------------------------------------
 * Event fired after cloning completion
 * Allows modules to perform post-cloning actions or setup
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectCloned {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $source_project;
    public $cloned_project;
    public $clone_results;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after cloning completion, before response,
     * allowing modules to perform post-cloning actions or setup
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \App\Models\Project  $source_project  Original project model object
     * @param  \App\Models\Project  $cloned_project  New cloned project model object
     * @param  array  $clone_results  Details of what was cloned
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $source_project, $cloned_project, $clone_results, $payload) {
        $this->request = $request;
        $this->source_project = $source_project;
        $this->cloned_project = $cloned_project;
        $this->clone_results = $clone_results;
        $this->payload = $payload;
    }
}
