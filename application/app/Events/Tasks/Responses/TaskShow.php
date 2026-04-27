<?php

/** --------------------------------------------------------------------------------
 * Event fired when task details view is being rendered
 * Allows modules to extend the task view with additional data and sections
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Tasks\Responses;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskShow {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $payload;
    public $view;

    /**
     * Create a new event instance.
     * This event is fired before the task details view is rendered,
     * allowing modules to modify the payload data and inject additional view sections
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request object
     * @param  array  $payload  Reference to the view data array (task, comments, attachments, etc.)
     * @param  string  $view  The view path being rendered (e.g., 'pages/task/leftpanel')
     * @return void
     */
    public function __construct($request, &$payload, $view = null) {
        $this->request = $request;
        $this->payload = &$payload;
        $this->view = $view;
    }
}
