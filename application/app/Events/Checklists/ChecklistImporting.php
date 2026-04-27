<?php

/** --------------------------------------------------------------------------------
 * Event fired before checklist import execution
 * Allows modules to perform pre-action logic before checklists are imported
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Checklists;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChecklistImporting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $checklistresource_type;
    public $checklistresource_id;

    /**
     * Create a new event instance.
     * This event is fired before checklist import execution
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  string  $checklistresource_type  Resource type (task, project, etc.)
     * @param  int  $checklistresource_id  Resource ID
     * @return void
     */
    public function __construct($request, $checklistresource_type, $checklistresource_id) {
        $this->request = $request;
        $this->checklistresource_type = $checklistresource_type;
        $this->checklistresource_id = $checklistresource_id;
    }
}
