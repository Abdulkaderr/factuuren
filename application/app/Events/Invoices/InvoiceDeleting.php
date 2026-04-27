<?php

/** --------------------------------------------------------------------------------
 * Event fired before invoice deletion
 * Allows modules to perform pre-action logic before invoices are deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceDeleting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $invoice_ids;

    /**
     * Create a new event instance.
     * This event is fired before invoice deletion
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $invoice_ids  Array of invoice IDs to be deleted
     * @return void
     */
    public function __construct($request, $invoice_ids) {
        $this->request = $request;
        $this->invoice_ids = $invoice_ids;
    }
}
