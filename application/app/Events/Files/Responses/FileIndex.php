<?php

/** --------------------------------------------------------------------------------
 * Event fired when file index page is being rendered
 * Allows modules to extend the page with additional data and blade stacks
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Files\Responses;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileIndex {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired before the file index page is rendered,
     * allowing modules to modify the payload data and inject blade stacks
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $payload  Reference to the page data array (files, stats, folders, tags, etc.)
     * @return void
     */
    public function __construct($request, &$payload) {
        $this->request = $request;
        $this->payload = &$payload;
    }
}
