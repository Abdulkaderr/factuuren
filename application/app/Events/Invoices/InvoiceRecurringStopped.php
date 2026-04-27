<?php

/** --------------------------------------------------------------------------------
 * Event fired after invoice recurring stopped, before response
 * Allows modules to perform actions after recurring has been stopped
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceRecurringStopped {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $invoice_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after recurring stopped, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $invoice_id  Updated invoice ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $invoice_id, $payload) {
        $this->request = $request;
        $this->invoice_id = $invoice_id;
        $this->payload = $payload;
    }
}
