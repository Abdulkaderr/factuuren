<?php

/** --------------------------------------------------------------------------------
 * Event fired after checklist creation, before response
 * Allows modules to save their custom data after the checklist has been created
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Checklists;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChecklistStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $checklist_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after checklist creation, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $checklist_id  Created checklist ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $checklist_id, $payload) {
        $this->request = $request;
        $this->checklist_id = $checklist_id;
        $this->payload = $payload;
    }
}
