<?php

/** --------------------------------------------------------------------------------
 * Event fired after project attached to invoice, before response
 * Allows modules to perform actions after project has been attached
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceProjectAttached {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $invoice_id;
    public $project_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after project attachment, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $invoice_id  Updated invoice ID
     * @param  int  $project_id  Attached project ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $invoice_id, $project_id, $payload) {
        $this->request = $request;
        $this->invoice_id = $invoice_id;
        $this->project_id = $project_id;
        $this->payload = $payload;
    }
}
