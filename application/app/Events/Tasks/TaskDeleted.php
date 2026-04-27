<?php

/** --------------------------------------------------------------------------------
 * Event fired after successful task deletion operations
 * Allows modules to perform post-deletion cleanup or notifications
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskDeleted {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $deleted_ids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after all deletion operations complete,
     * allowing modules to perform post-deletion cleanup or notifications
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  array  $deleted_ids  Array of successfully deleted task IDs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $deleted_ids, $payload) {
        $this->request = $request;
        $this->deleted_ids = $deleted_ids;
        $this->payload = $payload;
    }
}
