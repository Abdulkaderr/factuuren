<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before client update
 * Allows modules to perform pre-action logic before client is updated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Clients;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientUpdating {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $client_id;

    /**
     * Create a new event instance.
     * This event is fired after validation, before client update
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $client_id  Client ID being updated
     * @return void
     */
    public function __construct($request, $client_id) {
        $this->request = $request;
        $this->client_id = $client_id;
    }
}
