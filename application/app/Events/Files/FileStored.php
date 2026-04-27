<?php

/** --------------------------------------------------------------------------------
 * Event fired after file storage and tag application, before response
 * Allows modules to save their custom data after the file has been stored
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Files;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $file_ids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after file storage and tag application, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  array  $file_ids  Array of created file IDs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $file_ids, $payload) {
        $this->request = $request;
        $this->file_ids = $file_ids;
        $this->payload = $payload;
    }
}
