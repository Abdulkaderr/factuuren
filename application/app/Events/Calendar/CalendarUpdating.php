<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before update
 * Allows modules to perform pre-action logic before calendar item is updated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Calendar;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CalendarUpdating {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $event_id;

    /**
     * Create a new event instance.
     * This event is fired after validation, before update
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  string  $event_id  Event unique ID
     * @return void
     */
    public function __construct($request, $event_id) {
        $this->request = $request;
        $this->event_id = $event_id;
    }
}
