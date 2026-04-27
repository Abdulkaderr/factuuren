<?php

/** --------------------------------------------------------------------------------
 * Event fired after project category updates and user reassignments
 * Allows modules to update external systems or trigger category-based workflows
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectCategoryChanged {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $updated_projects;
    public $category;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after all category updates and user reassignments, before response,
     * allowing modules to update external systems or trigger category-based workflows
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  \Illuminate\Support\Collection  $updated_projects  Collection of updated project objects
     * @param  \App\Models\Category  $category  New category object
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $updated_projects, $category, $payload) {
        $this->request = $request;
        $this->updated_projects = $updated_projects;
        $this->category = $category;
        $this->payload = $payload;
    }
}
