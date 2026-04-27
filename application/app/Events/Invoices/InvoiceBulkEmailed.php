<?php

/** --------------------------------------------------------------------------------
 * Event fired after bulk invoice emailing, before response
 * Allows modules to perform actions after bulk emails have been sent
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceBulkEmailed {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $emailed_invoice_ids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after bulk emailing, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $emailed_invoice_ids  Array of successfully emailed invoice IDs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $emailed_invoice_ids, $payload) {
        $this->request = $request;
        $this->emailed_invoice_ids = $emailed_invoice_ids;
        $this->payload = $payload;
    }
}
