<?php

/** --------------------------------------------------------------------------------
 * Event fired after estimate cloning, before response
 * Allows modules to perform actions after estimate has been cloned
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Estimates;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EstimateCloned {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $source_estimateid;
    public $new_estimateid;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after estimate cloning, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $source_estimateid  Source estimate ID
     * @param  int  $new_estimateid  Cloned estimate ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $source_estimateid, $new_estimateid, $payload) {
        $this->request = $request;
        $this->source_estimateid = $source_estimateid;
        $this->new_estimateid = $new_estimateid;
        $this->payload = $payload;
    }
}
