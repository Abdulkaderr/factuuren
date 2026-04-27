<?php

/** --------------------------------------------------------------------------------
 * Event fired after bulk project timers are stopped
 * Allows modules to perform actions after timers are stopped
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectBulkTimersStopped {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project_ids;
    public $stopped_timers;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after all timers are stopped,
     * allowing modules to perform actions after bulk timer operations are completed
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  array  $project_ids  Array of project IDs whose timers were stopped
     * @param  mixed  $stopped_timers  Details of all stopped timers
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $project_ids, $stopped_timers, $payload) {
        $this->request = $request;
        $this->project_ids = $project_ids;
        $this->stopped_timers = $stopped_timers;
        $this->payload = $payload;
    }
}
