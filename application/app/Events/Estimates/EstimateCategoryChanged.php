<?php

/** --------------------------------------------------------------------------------
 * Event fired after category update, before response
 * Allows modules to perform actions after estimate category has been changed
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Estimates;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EstimateCategoryChanged {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $bill_estimateids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after category update, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $bill_estimateids  Array of estimate IDs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $bill_estimateids, $payload) {
        $this->request = $request;
        $this->bill_estimateids = $bill_estimateids;
        $this->payload = $payload;
    }
}
