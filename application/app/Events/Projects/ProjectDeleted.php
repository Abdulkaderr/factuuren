<?php

/** --------------------------------------------------------------------------------
 * Event fired after project deletion operations complete
 * Allows modules to perform cleanup after projects have been deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectDeleted {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $deleted_ids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after all deletion operations complete,
     * allowing modules to perform post-deletion cleanup
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  array  $deleted_ids  Array of successfully deleted project IDs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $deleted_ids, $payload) {
        $this->request = $request;
        $this->deleted_ids = $deleted_ids;
        $this->payload = $payload;
    }
}
