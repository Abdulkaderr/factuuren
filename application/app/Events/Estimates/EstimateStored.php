<?php

/** --------------------------------------------------------------------------------
 * Event fired after estimate creation, before response
 * Allows modules to save their custom data after the estimate has been created
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Estimates;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EstimateStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $bill_estimateid;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after estimate creation, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $bill_estimateid  Created estimate ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $bill_estimateid, $payload) {
        $this->request = $request;
        $this->bill_estimateid = $bill_estimateid;
        $this->payload = $payload;
    }
}
