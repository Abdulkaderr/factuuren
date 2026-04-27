<?php

/** --------------------------------------------------------------------------------
 * Event fired after file deleted from invoice, before response
 * Allows modules to perform actions after file has been deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Invoices;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceFileDeleted {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $file_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after file deletion, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  string  $file_id  Deleted file unique ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $file_id, $payload) {
        $this->request = $request;
        $this->file_id = $file_id;
        $this->payload = $payload;
    }
}
