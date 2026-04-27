<?php

/** --------------------------------------------------------------------------------
 * Event fired after bulk project detachment, before response
 * Allows modules to perform actions after projects have been detached from invoices
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceBulkProjectDetached {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $detached_invoice_ids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after bulk project detachment, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $detached_invoice_ids  Array of invoice IDs detached from projects
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $detached_invoice_ids, $payload) {
        $this->request = $request;
        $this->detached_invoice_ids = $detached_invoice_ids;
        $this->payload = $payload;
    }
}
