<?php

/** --------------------------------------------------------------------------------
 * Event fired after invoice category change, before response
 * Allows modules to perform actions after invoice categories have been changed
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceCategoryChanged {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $updated_invoice_ids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after category change, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $updated_invoice_ids  Array of updated invoice IDs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $updated_invoice_ids, $payload) {
        $this->request = $request;
        $this->updated_invoice_ids = $updated_invoice_ids;
        $this->payload = $payload;
    }
}
