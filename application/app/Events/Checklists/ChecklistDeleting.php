<?php

/** --------------------------------------------------------------------------------
 * Event fired before checklist deletion
 * Allows modules to perform pre-action logic before checklist is deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Checklists;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChecklistDeleting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $checklist_id;

    /**
     * Create a new event instance.
     * This event is fired before checklist deletion
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $checklist_id  Checklist ID
     * @return void
     */
    public function __construct($request, $checklist_id) {
        $this->request = $request;
        $this->checklist_id = $checklist_id;
    }
}
