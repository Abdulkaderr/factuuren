<?php

/** --------------------------------------------------------------------------------
 * Event fired after deletion, before response
 * Allows modules to perform cleanup after calendar item has been deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Calendar;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CalendarDeleted {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $event_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after deletion, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  string  $event_id  Deleted event unique ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $event_id, $payload) {
        $this->request = $request;
        $this->event_id = $event_id;
        $this->payload = $payload;
    }
}
