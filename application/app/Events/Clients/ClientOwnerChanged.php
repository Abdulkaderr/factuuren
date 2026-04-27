<?php

/** --------------------------------------------------------------------------------
 * Event fired after owner change, before response
 * Allows modules to perform logic after owner has been changed
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Clients;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientOwnerChanged {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $client_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after owner change, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $client_id  Client ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $client_id, $payload) {
        $this->request = $request;
        $this->client_id = $client_id;
        $this->payload = $payload;
    }
}
