<?php

/** --------------------------------------------------------------------------------
 * Event fired when project details view is being rendered
 * Allows modules to extend the view with additional fields and data
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects\Responses;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectDetails {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $payload;

    /**
     * Create a new event instance.
     * This event is fired before the project details view is rendered,
     * allowing modules to modify the payload data and inject additional content
     *
     * @param  array  $payload  Reference to the view data array (page, project, tags, etc.)
     * @return void
     */
    public function __construct(&$payload) {
        $this->payload = &$payload;
    }
}
