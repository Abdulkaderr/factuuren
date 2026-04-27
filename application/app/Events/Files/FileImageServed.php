<?php

/** --------------------------------------------------------------------------------
 * Event fired after image retrieval, before serving
 * Allows modules to perform post-action logic before image is served
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Files;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileImageServed {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $file_id;

    /**
     * Create a new event instance.
     * This event is fired after image retrieval, before serving
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
