<?php

/** --------------------------------------------------------------------------------
 * Event fired after event marking, before file download
 * Allows modules to perform post-action logic before file is downloaded
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Files;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileDownloaded {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $file_id;

    /**
     * Create a new event instance.
     * This event is fired after event marking, before file download
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  string  $file_id  File unique ID
     * @return void
     */
    public function __construct($request, $file_id) {
        $this->request = $request;
        $this->file_id = $file_id;
    }
}
