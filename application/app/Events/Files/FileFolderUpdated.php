<?php

/** --------------------------------------------------------------------------------
 * Event fired after folder updates, before response
 * Allows modules to perform post-action logic after folders have been updated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Files;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileFolderUpdated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $filefolder_ids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after folder updates, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  array  $filefolder_ids  Array of updated folder IDs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $filefolder_ids, $payload) {
        $this->request = $request;
        $this->filefolder_ids = $filefolder_ids;
        $this->payload = $payload;
    }
}
