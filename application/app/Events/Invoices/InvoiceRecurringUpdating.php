<?php

/** --------------------------------------------------------------------------------
 * Event fired before invoice recurring settings update
 * Allows modules to perform pre-action logic before recurring settings are updated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceRecurringUpdating {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $invoice_id;

    /**
     * Create a new event instance.
     * This event is fired before recurring settings update
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $invoice_id  Invoice ID being updated
     * @return void
     */
    public function __construct($request, $invoice_id) {
        $this->request = $request;
        $this->invoice_id = $invoice_id;
    }
}
