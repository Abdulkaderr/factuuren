<?php

/** --------------------------------------------------------------------------------
 * Event fired after estimate is resent via email, before response
 * Allows modules to perform actions after estimate has been resent
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Estimates;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EstimateResent {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $bill_estimateid;

    /**
     * Create a new event instance.
     * This event is fired after email sending, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $bill_estimateid  Estimate ID
     * @return void
     */
    public function __construct($request, $bill_estimateid) {
        $this->request = $request;
        $this->bill_estimateid = $bill_estimateid;
    }
}
