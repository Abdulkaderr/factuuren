<?php

/** --------------------------------------------------------------------------------
 * Event fired before file deletion
 * Allows modules to perform pre-action logic before file is deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Files;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileDeleting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $file_ids;

    /**
     * Create a new event instance.
     * This event is fired before file deletion
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $file_ids  Array of file IDs
     * @return void
     */
    public function __construct($request, $file_ids) {
        $this->request = $request;
        $this->file_ids = $file_ids;
    }
}
