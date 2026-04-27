<?php

/** --------------------------------------------------------------------------------
 * Event fired after pin toggle, before response
 * Allows modules to perform actions after estimate pin state has been toggled
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Estimates;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EstimatePinToggled {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $bill_estimateid;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after pin toggle, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $bill_estimateid  Estimate ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $bill_estimateid, $payload) {
        $this->request = $request;
        $this->bill_estimateid = $bill_estimateid;
        $this->payload = $payload;
    }
}
