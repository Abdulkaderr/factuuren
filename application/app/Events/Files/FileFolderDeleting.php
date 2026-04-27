<?php

/** --------------------------------------------------------------------------------
 * Event fired before folder deletion
 * Allows modules to perform pre-action logic before folder is deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Files;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileFolderDeleting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $filefolder_id;

    /**
     * Create a new event instance.
     * This event is fired before folder deletion
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $filefolder_id  Folder ID
     * @return void
     */
    public function __construct($request, $filefolder_id) {
        $this->request = $request;
        $this->filefolder_id = $filefolder_id;
    }
}
