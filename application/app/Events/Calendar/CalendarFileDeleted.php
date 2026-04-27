<?php

/** --------------------------------------------------------------------------------
 * Event fired after file deletion, before response
 * Allows modules to perform cleanup after file has been deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Calendar;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CalendarFileDeleted {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $file_uniqueid;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after file deletion, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  string  $file_uniqueid  Deleted file unique ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $file_uniqueid, $payload) {
        $this->request = $request;
        $this->file_uniqueid = $file_uniqueid;
        $this->payload = $payload;
    }
}
