<?php

/** --------------------------------------------------------------------------------
 * Event fired after core request validation but before project creation
 * Allows modules to perform manual validation on their custom fields
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectStoring {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;

    /**
     * Create a new event instance.
     * This event is fired after core validation passes but before project creation,
     * allowing modules to perform manual validation on their custom fields
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request with validated data
     * @return void
     */
    public function __construct($request) {
        $this->request = $request;
    }
}
