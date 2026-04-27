<?php

/** --------------------------------------------------------------------------------
 * Event fired before attachment download
 * Allows modules to perform post-action logic before attachment is downloaded
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Files;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AttachmentDownloaded {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $attachment_id;

    /**
     * Create a new event instance.
     * This event is fired before attachment download
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  string  $attachment_id  Attachment unique ID
     * @return void
     */
    public function __construct($request, $attachment_id) {
        $this->request = $request;
        $this->attachment_id = $attachment_id;
    }
}
