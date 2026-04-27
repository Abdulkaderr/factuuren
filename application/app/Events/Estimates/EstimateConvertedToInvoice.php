<?php

/** --------------------------------------------------------------------------------
 * Event fired after conversion to invoice, before response
 * Allows modules to perform actions after estimate has been converted to invoice
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Estimates;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EstimateConvertedToInvoice {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $bill_estimateid;
    public $bill_invoiceid;

    /**
     * Create a new event instance.
     * This event is fired after conversion to invoice, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $bill_estimateid  Original estimate ID
     * @param  int  $bill_invoiceid  Created invoice ID
     * @return void
     */
    public function __construct($request, $bill_estimateid, $bill_invoiceid) {
        $this->request = $request;
        $this->bill_estimateid = $bill_estimateid;
        $this->bill_invoiceid = $bill_invoiceid;
    }
}
