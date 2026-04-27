<?php

/** --------------------------------------------------------------------------------
 * Event fired after file deletion
 * Allows modules to perform cleanup after file has been deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Estimates;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EstimateFileDeleted {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $file_uniqueid;

    /**
     * Create a new event instance.
     * This event is fired after file deletion
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  string  $file_uniqueid  Deleted file unique ID
     * @return void
     */
    public function __construct($request, $file_uniqueid) {
        $this->request = $request;
        $this->file_uniqueid = $file_uniqueid;
    }
}
