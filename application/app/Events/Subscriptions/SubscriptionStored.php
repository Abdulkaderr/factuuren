<?php

/** --------------------------------------------------------------------------------
 * Event fired after subscription creation and event recording, before response
 * Allows modules to save their custom data after the subscription has been created
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Subscriptions;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $subscription_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after subscription creation and event recording, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $subscription_id  Created subscription ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $subscription_id, $payload) {
        $this->request = $request;
        $this->subscription_id = $subscription_id;
        $this->payload = $payload;
    }
}
