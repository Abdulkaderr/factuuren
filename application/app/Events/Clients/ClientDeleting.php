<?php

/** --------------------------------------------------------------------------------
 * Event fired before deletion operations
 * Allows modules to perform pre-deletion logic or cleanup
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Clients;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientDeleting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $client_id;

    /**
     * Create a new event instance.
     * This event is fired before deletion operations
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $client_id  Client ID to be deleted
     * @return void
     */
    public function __construct($request, $client_id) {
        $this->request = $request;
        $this->client_id = $client_id;
    }
}
