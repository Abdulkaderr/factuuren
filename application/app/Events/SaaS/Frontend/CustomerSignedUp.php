<?php

/** --------------------------------------------------------------------------------
 * Event fired after customer signup via frontend, before response
 * Allows modules to perform actions after a new customer has signed up
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\SaaS\Frontend;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerSignedUp {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after customer signup, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $payload) {
        $this->request = $request;
        $this->payload = $payload;
    }
}
