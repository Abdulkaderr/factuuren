<?php

/** --------------------------------------------------------------------------------
 * Event fired before overdue reminder email is sent
 * Allows modules to perform pre-action logic before overdue reminder is sent
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceOverdueReminding {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $invoice_id;

    /**
     * Create a new event instance.
     * This event is fired before overdue reminder email is sent
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $invoice_id  Invoice ID
     * @return void
     */
    public function __construct($request, $invoice_id) {
        $this->request = $request;
        $this->invoice_id = $invoice_id;
    }
}
