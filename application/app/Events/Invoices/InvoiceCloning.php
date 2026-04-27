<?php

/** --------------------------------------------------------------------------------
 * Event fired before invoice cloning
 * Allows modules to perform pre-action logic before invoice is cloned
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceCloning {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $source_invoice_id;

    /**
     * Create a new event instance.
     * This event is fired before invoice cloning
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $source_invoice_id  Original invoice ID
     * @return void
     */
    public function __construct($request, $source_invoice_id) {
        $this->request = $request;
        $this->source_invoice_id = $source_invoice_id;
    }
}
