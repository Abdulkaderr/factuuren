<?php

/** --------------------------------------------------------------------------------
 * Event fired when invoice create form is being rendered
 * Allows modules to extend the form with additional fields and data
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices\Responses;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceCreate {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $payload;

    /**
     * Create a new event instance.
     * This event is fired before the invoice create form is rendered,
     * allowing modules to modify the payload data and inject form fields
     *
     * @param  array  $payload  Reference to the form data array (categories, tags, fields, etc.)
     * @return void
     */
    public function __construct(&$payload) {
        $this->payload = &$payload;
    }
}