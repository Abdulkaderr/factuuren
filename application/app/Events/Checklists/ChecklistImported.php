<?php

/** --------------------------------------------------------------------------------
 * Event fired after checklist import completion, before response
 * Allows modules to save their custom data after the checklists have been imported
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Checklists;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChecklistImported {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $checklistresource_type;
    public $checklistresource_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after checklist import completion, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  string  $checklistresource_type  Resource type
     * @param  int  $checklistresource_id  Resource ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $checklistresource_type, $checklistresource_id, $payload) {
        $this->request = $request;
        $this->checklistresource_type = $checklistresource_type;
        $this->checklistresource_id = $checklistresource_id;
        $this->payload = $payload;
    }
}
