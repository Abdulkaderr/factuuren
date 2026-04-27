<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation but before task creation
 * Allows modules to perform manual validation on their custom fields
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskStoring {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;

    /**
     * Create a new event instance.
     * This event is fired after validation passes but before task creation,
     * allowing modules to perform manual validation on their custom fields
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @return void
     */
    public function __construct($request) {
        $this->request = $request;
    }
}
