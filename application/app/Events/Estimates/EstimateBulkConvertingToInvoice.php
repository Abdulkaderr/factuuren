<?php

/** --------------------------------------------------------------------------------
 * Event fired before bulk conversion to invoices
 * Allows modules to perform pre-action logic before estimates are bulk converted to invoices
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Estimates;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EstimateBulkConvertingToInvoice {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $bill_estimateids;

    /**
     * Create a new event instance.
     * This event is fired before bulk conversion to invoices
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
