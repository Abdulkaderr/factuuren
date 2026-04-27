<?php

/** --------------------------------------------------------------------------------
 * Event fired after project timers are stopped
 * Allows modules to perform actions after timers are stopped
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectTimersStopped {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project_id;
    public $stopped_timers;

    /**
     * Create a new event instance.
     * This event is fired after all timers are stopped,
     * allowing modules to perform actions after timers are stopped
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  mixed  $project_id  Project ID whose timers were stopped
     * @param  mixed  $stopped_timers  Count or details of stopped timers
     * @return void
     */
    public function __construct($request, $project_id, $stopped_timers) {
        $this->request = $request;
        $this->project_id = $project_id;
        $this->stopped_timers = $stopped_timers;
    }
}
