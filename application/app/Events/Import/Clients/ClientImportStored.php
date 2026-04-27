<?php

/** --------------------------------------------------------------------------------
 * Event fired after client import completion, before response
 * Allows modules to perform post-import actions and access import results
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Import\Clients;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientImportStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $import_ref;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after client import completion, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  string  $import_ref  Unique import reference/transaction ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $import_ref, $payload) {
        $this->request = $request;
        $this->import_ref = $import_ref;
        $this->payload = $payload;
    }
}
