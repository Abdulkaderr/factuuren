<?php

/** --------------------------------------------------------------------------------
 * Event fired before attachment deletion
 * Allows modules to perform cleanup or validation before attachment is deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Expenses;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExpenseAttachmentDeleting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $attachment_uniqueid;

    /**
     * Create a new event instance.
     * This event is fired before attachment deletion
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  string  $attachment_uniqueid  Attachment unique ID
     * @return void
     */
    public function __construct($request, $attachment_uniqueid) {
        $this->request = $request;
        $this->attachment_uniqueid = $attachment_uniqueid;
    }
}
