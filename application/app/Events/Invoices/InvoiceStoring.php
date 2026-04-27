<?php

/** --------------------------------------------------------------------------------
 * Event fired after core request validation but before invoice storage
 * Allows modules to perform manual validation on their custom fields
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceStoring {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request_data;
    public $validated_input;

    /**
     * Create a new event instance.
     * This event is fired after core validation passes but before invoice creation,
     * allowing modules to perform manual validation on their custom fields
     *
     * @param  array  $request_data  The request data from the form
     * @param  array  $validated_input  The validated input that passed core validation
     * @return void
     */
    public function __construct($request_data, $validated_input) {
        $this->request_data = $request_data;
        $this->validated_input = $validated_input;
    }
}