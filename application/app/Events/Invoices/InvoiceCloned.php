<?php

/** --------------------------------------------------------------------------------
 * Event fired after invoice cloning, before response
 * Allows modules to perform actions after invoice has been cloned
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceCloned {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $source_invoice_id;
    public $cloned_invoice_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after invoice cloning, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $source_invoice_id  Original invoice ID
     * @param  int  $cloned_invoice_id  New cloned invoice ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $source_invoice_id, $cloned_invoice_id, $payload) {
        $this->request = $request;
        $this->source_invoice_id = $source_invoice_id;
        $this->cloned_invoice_id = $cloned_invoice_id;
        $this->payload = $payload;
    }
}
