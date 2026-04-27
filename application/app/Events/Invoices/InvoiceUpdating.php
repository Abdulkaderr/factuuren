<?php

/** --------------------------------------------------------------------------------
 * Event fired before invoice line items are saved/updated
 * Allows modules to perform validation on invoice changes before processing
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceUpdating {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $invoice;
    public $request_data;

    /**
     * Create a new event instance.
     * This event is fired before invoice line items are processed,
     * allowing modules to perform validation on invoice changes
     *
     * @param  object  $invoice  The invoice being updated
     * @param  array  $request_data  The request data containing line items
     * @return void
     */
    public function __construct($invoice, $request_data) {
        $this->invoice = $invoice;
        $this->request_data = $request_data;
    }
}
