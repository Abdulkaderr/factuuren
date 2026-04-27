<?php

/** --------------------------------------------------------------------------------
 * Event fired after update, before response
 * Allows modules to save their custom data after calendar item has been updated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Calendar;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CalendarUpdated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $event_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after update, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  string  $event_id  Event unique ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $event_id, $payload) {
        $this->request = $request;
        $this->event_id = $event_id;
        $this->payload = $payload;
    }
}
