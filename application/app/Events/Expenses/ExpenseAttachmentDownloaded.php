<?php

/** --------------------------------------------------------------------------------
 * Event fired after successful file retrieval, before download
 * Allows modules to track or log attachment download activity
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Expenses;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExpenseAttachmentDownloaded {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $attachment_uniqueid;

    /**
     * Create a new event instance.
     * This event is fired after successful file retrieval, before download
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
