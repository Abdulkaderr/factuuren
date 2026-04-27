<?php

/** --------------------------------------------------------------------------------
 * Event fired before PDF generation and file save
 * Allows modules to perform pre-action logic before PDF is generated
 * Modules can modify the blade template path via $payload['blade']
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\EmailBills;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PDFSaving {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $bill_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after payload extraction, before PDF generation and file save
     *
     * @param  int  $bill_id  The invoice or estimate ID (bill_invoiceid or bill_estimateid)
     * @param  array  $payload  Reference to the payload array (allows modification of blade template)
     * @return void
     */
    public function __construct($bill_id, &$payload) {
        $this->bill_id = $bill_id;
        $this->payload = &$payload;
    }
}
