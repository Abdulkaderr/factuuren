<?php

/** --------------------------------------------------------------------------------
 * Event fired after attachment deletion
 * Allows modules to perform cleanup after attachment has been deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Expenses;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExpenseAttachmentDeleted {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $attachment_uniqueid;

    /**
     * Create a new event instance.
     * This event is fired after attachment deletion
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  string  $attachment_uniqueid  Deleted attachment unique ID
     * @return void
     */
    public function __construct($request, $attachment_uniqueid) {
        $this->request = $request;
        $this->attachment_uniqueid = $attachment_uniqueid;
    }
}
