<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before checklist creation
 * Allows modules to perform pre-action logic before checklist is stored
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Checklists;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChecklistStoring {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $checklistresource_type;
    public $checklistresource_id;

    /**
     * Create a new event instance.
     * This event is fired after validation, before checklist creation
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  string  $checklistresource_type  Resource type
     * @param  int  $checklistresource_id  Resource ID
     * @return void
     */
    public function __construct($request, $checklistresource_type, $checklistresource_id) {
        $this->request = $request;
        $this->checklistresource_type = $checklistresource_type;
        $this->checklistresource_id = $checklistresource_id;
    }
}
