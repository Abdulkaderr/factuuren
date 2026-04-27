<?php

/** --------------------------------------------------------------------------------
 * Event fired after file attached to invoice, before response
 * Allows modules to perform actions after file has been attached
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceFileAttached {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $file_id;
    public $invoice_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after file attached, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  string  $file_id  Created file unique ID
     * @param  int  $invoice_id  Invoice ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $file_id, $invoice_id, $payload) {
        $this->request = $request;
        $this->file_id = $file_id;
        $this->invoice_id = $invoice_id;
        $this->payload = $payload;
    }
}
