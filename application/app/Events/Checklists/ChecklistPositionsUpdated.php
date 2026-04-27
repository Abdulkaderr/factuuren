<?php

/** --------------------------------------------------------------------------------
 * Event fired after position updates, before response
 * Allows modules to perform actions after checklist positions have been updated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Checklists;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChecklistPositionsUpdated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $checklist_ids;

    /**
     * Create a new event instance.
     * This event is fired after position updates, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $checklist_ids  Array of checklist IDs
     * @return void
     */
    public function __construct($request, $checklist_ids) {
        $this->request = $request;
        $this->checklist_ids = $checklist_ids;
    }
}
