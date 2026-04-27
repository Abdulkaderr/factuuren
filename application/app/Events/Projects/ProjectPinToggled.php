<?php

/** --------------------------------------------------------------------------------
 * Event fired after pin status change
 * Allows modules to track user preferences and customize pinned item behaviors
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectPinToggled {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project_id;
    public $pin_status;
    public $user_id;

    /**
     * Create a new event instance.
     * This event is fired after pin status change,
     * allowing modules to track user preferences and customize pinned item behaviors
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $project_id  Project ID
     * @param  string  $pin_status  New pin status (pinned/unpinned)
     * @param  int  $user_id  User who toggled the pin
     * @return void
     */
    public function __construct($request, $project_id, $pin_status, $user_id) {
        $this->request = $request;
        $this->project_id = $project_id;
        $this->pin_status = $pin_status;
        $this->user_id = $user_id;
    }
}
