<?php

/** --------------------------------------------------------------------------------
 * Event fired after bulk conversion to invoices, before response
 * Allows modules to perform actions after estimates have been bulk converted to invoices
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Estimates;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EstimateBulkConvertedToInvoice {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $bill_estimateids;
    public $bill_invoiceids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after bulk conversion to invoices, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $bill_estimateids  Array of original estimate IDs
     * @param  array  $bill_invoiceids  Array of created invoice IDs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $bill_estimateids, $bill_invoiceids, $payload) {
        $this->request = $request;
        $this->bill_estimateids = $bill_estimateids;
        $this->bill_invoiceids = $bill_invoiceids;
        $this->payload = $payload;
    }
}
