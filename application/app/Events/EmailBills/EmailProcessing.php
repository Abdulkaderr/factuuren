<?php

/** --------------------------------------------------------------------------------
 * Event fired before processing each queued email
 * Allows modules to perform pre-action logic before email is processed
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\EmailBills;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailProcessing {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $email_id;

    /**
     * Create a new event instance.
     * This event is fired before processing each queued email
     *
     * @param  int  $email_id  The emailqueue_id from the email queue table
     * @return void
     */
    public function __construct($email_id) {
        $this->email_id = $email_id;
    }
}
