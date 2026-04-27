<?php

/** --------------------------------------------------------------------------------
 * Event fired before project category updates and user reassignments
 * Allows modules to perform validation before category changes
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectCategoryChanging {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project_ids;
    public $new_category_id;

    /**
     * Create a new event instance.
     * This event is fired before category updates and user reassignments,
     * allowing modules to perform validation or preparation
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $project_ids  Array of project IDs to update
     * @param  int  $new_category_id  New category ID
     * @return void
     */
    public function __construct($request, $project_ids, $new_category_id) {
        $this->request = $request;
        $this->project_ids = $project_ids;
        $this->new_category_id = $new_category_id;
    }
}
