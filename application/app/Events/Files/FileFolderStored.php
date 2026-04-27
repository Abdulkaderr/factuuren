<?php

/** --------------------------------------------------------------------------------
 * Event fired after folder creation, before response
 * Allows modules to save their custom data after the folder has been created
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Files;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileFolderStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $filefolder_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after folder creation, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $filefolder_id  Created folder ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $filefolder_id, $payload) {
        $this->request = $request;
        $this->filefolder_id = $filefolder_id;
        $this->payload = $payload;
    }
}
