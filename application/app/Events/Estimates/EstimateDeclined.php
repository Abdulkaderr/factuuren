<?php

/** --------------------------------------------------------------------------------
 * Event fired after estimate decline, before response
 * Allows modules to perform actions after estimate has been declined
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Estimates;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EstimateDeclined {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $bill_estimateid;

    /**
     * Create a new event instance.
     * This event is fired after estimate decline, before response
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
