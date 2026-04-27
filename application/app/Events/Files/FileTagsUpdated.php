<?php

/** --------------------------------------------------------------------------------
 * Event fired after tag update, before response
 * Allows modules to perform post-action logic after file tags have been updated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Files;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileTagsUpdated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $file_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after tag update, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $file_id  File ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $file_id, $payload) {
        $this->request = $request;
        $this->file_id = $file_id;
        $this->payload = $payload;
    }
}
