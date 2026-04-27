<?php

/** --------------------------------------------------------------------------------
 * Event fired after file update, before response
 * Allows modules to perform post-action logic after file has been updated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Files;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileUpdated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $file_id;

    /**
     * Create a new event instance.
     * This event is fired after file update, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $file_id  File ID
     * @return void
     */
    public function __construct($request, $file_id) {
        $this->request = $request;
        $this->file_id = $file_id;
    }
}
