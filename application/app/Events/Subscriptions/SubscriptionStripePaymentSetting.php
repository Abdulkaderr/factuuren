<?php

/** --------------------------------------------------------------------------------
 * Event fired before Stripe session creation
 * Allows modules to perform pre-action logic before Stripe payment setup
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Subscriptions;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionStripePaymentSetting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $subscription_id;

    /**
     * Create a new event instance.
     * This event is fired before Stripe session creation
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $subscription_id  Subscription ID
     * @return void
     */
    public function __construct($request, $subscription_id) {
        $this->request = $request;
        $this->subscription_id = $subscription_id;
    }
}
