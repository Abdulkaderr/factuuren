<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before estimate update
 * Allows modules to perform pre-action logic before estimate is updated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Estimates;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EstimateUpdating {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $bill_estimateid;

    /**
     * Create a new event instance.
     * This event is fired after validation, before estimate update
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
