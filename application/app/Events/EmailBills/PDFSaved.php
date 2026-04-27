<?php

/** --------------------------------------------------------------------------------
 * Event fired after PDF file is saved to storage, before returning filepath
 * Allows modules to perform actions after PDF has been generated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\EmailBills;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PDFSaved {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $bill_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after PDF file is saved to storage, before returning filepath
     *
     * @param  int  $bill_id  The invoice or estimate ID
     * @param  array  $payload  Response data array containing filename and filepath
     * @return void
     */
    public function __construct($bill_id, $payload) {
        $this->bill_id = $bill_id;
        $this->payload = $payload;
    }
}
