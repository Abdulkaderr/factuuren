<?php

/** --------------------------------------------------------------------------------
 * Event fired before bulk invoice emailing
 * Allows modules to perform pre-action logic before bulk emails are sent
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceBulkEmailing {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $invoice_ids;

    /**
     * Create a new event instance.
     * This event is fired before bulk invoice emailing
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $invoice_ids  Array of invoice IDs to be emailed
     * @return void
     */
    public function __construct($request, $invoice_ids) {
        $this->request = $request;
        $this->invoice_ids = $invoice_ids;
    }
}
