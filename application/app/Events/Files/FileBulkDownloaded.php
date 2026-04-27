<?php

/** --------------------------------------------------------------------------------
 * Event fired after zip creation, before download
 * Allows modules to perform post-action logic before bulk download
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Files;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileBulkDownloaded {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $file_ids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after zip creation, before download
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  array  $file_ids  Array of file IDs included in download
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $file_ids, $payload) {
        $this->request = $request;
        $this->file_ids = $file_ids;
        $this->payload = $payload;
    }
}
