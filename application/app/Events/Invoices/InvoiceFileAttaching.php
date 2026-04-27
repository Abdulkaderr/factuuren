<?php

/** --------------------------------------------------------------------------------
 * Event fired before file attachment to invoice
 * Allows modules to perform pre-action logic before file is attached
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceFileAttaching {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $invoice_id;

    /**
     * Create a new event instance.
     * This event is fired before file attachment
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request with file data
     * @param  int  $invoice_id  Invoice ID
     * @return void
     */
    public function __construct($request, $invoice_id) {
        $this->request = $request;
        $this->invoice_id = $invoice_id;
    }
}
