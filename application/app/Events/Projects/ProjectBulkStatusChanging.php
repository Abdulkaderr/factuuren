<?php

/** --------------------------------------------------------------------------------
 * Event fired before bulk status updates
 * Allows modules to perform validation before status changes
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Projects;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectBulkStatusChanging {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project_ids;
    public $new_status;
    public $skip_notifications;

    /**
     * Create a new event instance.
     * This event is fired before any status updates,
     * allowing modules to perform validation or preparation
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $project_ids  Array of project IDs to update
     * @param  string  $new_status  New status value
     * @param  bool  $skip_notifications  Boolean indicating if notifications should be skipped
     * @return void
     */
    public function __construct($request, $project_ids, $new_status, $skip_notifications) {
        $this->request = $request;
        $this->project_ids = $project_ids;
        $this->new_status = $new_status;
        $this->skip_notifications = $skip_notifications;
    }
}
