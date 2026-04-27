<?php

/** --------------------------------------------------------------------------------
 * Event fired after status toggle, before response
 * Allows modules to perform actions after checklist status has been toggled
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Checklists;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChecklistStatusToggled {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $checklist_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after status toggle, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $checklist_id  Checklist ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $checklist_id, $payload) {
        $this->request = $request;
        $this->checklist_id = $checklist_id;
        $this->payload = $payload;
    }
}
