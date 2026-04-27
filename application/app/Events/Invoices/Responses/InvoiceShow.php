<?php

/** --------------------------------------------------------------------------------
 * Event fired when invoice show page is being rendered
 * Allows modules to extend the page with additional data and blade stacks
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices\Responses;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceShow {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired before the invoice show page is rendered,
     * allowing modules to modify the payload data and inject blade stacks
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $payload  Reference to the page data array (bill, customfields, files, etc.)
     * @return void
     */
    public function __construct($request, &$payload) {
        $this->request = $request;
        $this->payload = &$payload;
    }
}
