<?php

/** --------------------------------------------------------------------------------
 * Event fired after file upload, before response
 * Allows modules to perform actions after file has been attached to estimate
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Estimates;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EstimateFileAttached {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $bill_estimateid;
    public $file_uniqueid;

    /**
     * Create a new event instance.
     * This event is fired after file upload, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $bill_estimateid  Estimate ID
     * @param  string  $file_uniqueid  Uploaded file unique ID
     * @return void
     */
    public function __construct($request, $bill_estimateid, $file_uniqueid) {
        $this->request = $request;
        $this->bill_estimateid = $bill_estimateid;
        $this->file_uniqueid = $file_uniqueid;
    }
}
