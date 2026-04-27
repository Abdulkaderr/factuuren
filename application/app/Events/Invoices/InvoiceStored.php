<?php

/** --------------------------------------------------------------------------------
 * Event fired after successful invoice creation
 * Allows modules to save their custom data after the invoice has been created
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $invoice_id;
    public $invoice;
    public $request_data;

    /**
     * Create a new event instance.
     * This event is fired after successful invoice creation,
     * allowing modules to save their custom data related to the invoice
     *
     * @param  int  $invoice_id  The ID of the created invoice
     * @param  \App\Models\Invoice  $invoice  The created invoice model instance
     * @param  array  $request_data  The original request data from the form
     * @return void
     */
    public function __construct($invoice_id, $invoice, $request_data) {
        $this->invoice_id = $invoice_id;
        $this->invoice = $invoice;
        $this->request_data = $request_data;
    }
}