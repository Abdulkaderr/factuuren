<?php

/** --------------------------------------------------------------------------------
 * Event fired before task deletion operations begin
 * Allows modules to perform cleanup or prevent deletion
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskDeleting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;

    /**
     * Create a new event instance.
     * This event is fired before any deletion operations begin,
     * allowing modules to perform cleanup or prevent deletion
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @return void
     */
    public function __construct($request) {
        $this->request = $request;
    }
}
