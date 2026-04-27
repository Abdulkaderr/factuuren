<?php

/** --------------------------------------------------------------------------------
 * Event fired before file deletion
 * Allows modules to perform pre-action logic before file is deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Estimates;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EstimateFileDeleting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $file_uniqueid;

    /**
     * Create a new event instance.
     * This event is fired before file deletion
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  string  $file_uniqueid  File unique ID
     * @return void
     */
    public function __construct($request, $file_uniqueid) {
        $this->request = $request;
        $this->file_uniqueid = $file_uniqueid;
    }
}
