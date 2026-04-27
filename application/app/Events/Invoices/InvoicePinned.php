<?php

/** --------------------------------------------------------------------------------
 * Event fired after invoice pin toggle, before response
 * Allows modules to perform actions after invoice pin status has been toggled
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoicePinned {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $invoice_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after pin toggle, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $invoice_id  Invoice ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $invoice_id, $payload) {
        $this->request = $request;
        $this->invoice_id = $invoice_id;
        $this->payload = $payload;
    }
}
