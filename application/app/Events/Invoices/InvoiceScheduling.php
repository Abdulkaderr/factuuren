<?php

/** --------------------------------------------------------------------------------
 * Event fired before invoice scheduling for future publishing
 * Allows modules to perform pre-action logic before invoice is scheduled
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceScheduling {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $invoice_id;

    /**
     * Create a new event instance.
     * This event is fired before invoice scheduling
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $invoice_id  Invoice ID being scheduled
     * @return void
     */
    public function __construct($request, $invoice_id) {
        $this->request = $request;
        $this->invoice_id = $invoice_id;
    }
}
