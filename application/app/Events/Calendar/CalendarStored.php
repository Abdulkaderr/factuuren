<?php

/** --------------------------------------------------------------------------------
 * Event fired after calendar event creation, before response
 * Allows modules to save their custom data after the calendar event has been created
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Calendar;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CalendarStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $calendar_event_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after calendar event creation, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  string  $calendar_event_id  Created calendar event ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $calendar_event_id, $payload) {
        $this->request = $request;
        $this->calendar_event_id = $calendar_event_id;
        $this->payload = $payload;
    }
}
