<?php

/** --------------------------------------------------------------------------------
 * Event fired before stopping project timers
 * Allows modules to perform validation or modifications before timers are stopped
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectTimersStopping {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project_id;

    /**
     * Create a new event instance.
     * This event is fired before stopping any timers,
     * allowing modules to perform validation or modifications before timers are stopped
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  mixed  $project_id  Project ID whose timers will be stopped
     * @return void
     */
    public function __construct($request, $project_id) {
        $this->request = $request;
        $this->project_id = $project_id;
    }
}
