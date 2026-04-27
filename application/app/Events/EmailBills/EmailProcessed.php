<?php

/** --------------------------------------------------------------------------------
 * Event fired after email is sent and logged, before deletion from queue
 * Allows modules to perform actions after email has been processed
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\EmailBills;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailProcessed {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $email_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after email is sent and logged, before deletion from queue
     *
     * @param  int  $email_id  The emailqueue_id from the email queue table
     * @param  array  $payload  Response data array (optional, for additional context if needed)
     * @return void
     */
    public function __construct($email_id, $payload = []) {
        $this->email_id = $email_id;
        $this->payload = $payload;
    }
}
