<?php

/** --------------------------------------------------------------------------------
 * Event fired before project cloning operations begin
 * Allows modules to perform validation or preparation for cloning
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectCloning {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $source_project_id;
    public $clone_options;

    /**
     * Create a new event instance.
     * This event is fired before cloning operations begin,
     * allowing modules to perform validation or preparation
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $source_project_id  ID of project being cloned
     * @param  array  $clone_options  Array of selected clone options
     * @return void
     */
    public function __construct($request, $source_project_id, $clone_options) {
        $this->request = $request;
        $this->source_project_id = $source_project_id;
        $this->clone_options = $clone_options;
    }
}
