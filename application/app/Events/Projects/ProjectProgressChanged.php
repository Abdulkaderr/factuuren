<?php

/** --------------------------------------------------------------------------------
 * Event fired after project progress update
 * Allows modules to perform actions after progress changes are completed
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectProgressChanged {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project;
    public $old_progress;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after progress update,
     * allowing modules to perform actions after progress changes are completed
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \App\Models\Project  $project  Project model with updated progress
     * @param  mixed  $old_progress  Previous progress value
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $project, $old_progress, $payload) {
        $this->request = $request;
        $this->project = $project;
        $this->old_progress = $old_progress;
        $this->payload = $payload;
    }
}
