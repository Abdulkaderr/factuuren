<?php

/** --------------------------------------------------------------------------------
 * Event fired after pin toggle, before response
 * Allows modules to react to subscription pin state changes
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Subscriptions;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionPinToggled {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $subscription_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after pin toggle, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $subscription_id  Subscription ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $subscription_id, $payload) {
        $this->request = $request;
        $this->subscription_id = $subscription_id;
        $this->payload = $payload;
    }
}
