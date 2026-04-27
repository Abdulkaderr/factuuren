<?php

/** --------------------------------------------------------------------------------
 * Event fired before bulk project timers are stopped
 * Allows modules to perform validation or modifications before timers are stopped
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectBulkTimersStopping {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project_ids;

    /**
     * Create a new event instance.
     * This event is fired before stopping any timers,
     * allowing modules to perform validation or modifications before timers are stopped
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $project_ids  Array of project IDs whose timers will be stopped
     * @return void
     */
    public function __construct($request, $project_ids) {
        $this->request = $request;
        $this->project_ids = $project_ids;
    }
}
