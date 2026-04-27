<?php

/** --------------------------------------------------------------------------------
 * Event fired before estimate deletion
 * Allows modules to perform pre-action logic before estimate is deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Estimates;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EstimateDeleting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $bill_estimateids;

    /**
     * Create a new event instance.
     * This event is fired before estimate deletion
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $bill_estimateids  Array of estimate IDs
     * @return void
     */
    public function __construct($request, $bill_estimateids) {
        $this->request = $request;
        $this->bill_estimateids = $bill_estimateids;
    }
}
