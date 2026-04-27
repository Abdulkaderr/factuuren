<?php

/** --------------------------------------------------------------------------------
 * Event fired when project status change form is being rendered
 * Allows modules to extend the form with additional fields and data
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects\Responses;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectChangeStatus {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired before the project status change form is rendered,
     * allowing modules to modify the payload data and inject form fields
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $payload  Reference to the form data array (project, statuses, etc.)
     * @return void
     */
    public function __construct($request, &$payload) {
        $this->request = $request;
        $this->payload = &$payload;
    }
}
