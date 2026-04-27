<?php

/** --------------------------------------------------------------------------------
 * Event fired after automation settings update
 * Allows modules to perform post-automation setup or external integrations
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectAutomationUpdated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project;
    public $old_settings;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after automation settings update, before response,
     * allowing modules to perform post-automation setup or integrations
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \App\Models\Project  $project  Project model with updated automation settings
     * @param  array  $old_settings  Previous automation settings
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $project, $old_settings, $payload) {
        $this->request = $request;
        $this->project = $project;
        $this->old_settings = $old_settings;
        $this->payload = $payload;
    }
}
