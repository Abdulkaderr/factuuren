<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before bulk deletion
 * Allows modules to perform pre-action logic before proposals are deleted in bulk
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Proposals;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProposalBulkDeleting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $proposal_ids;

    /**
     * Create a new event instance.
     * This event is fired after validation, before bulk deletion
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $proposal_ids  Array of proposal IDs to be deleted
     * @return void
     */
    public function __construct($request, $proposal_ids) {
        $this->request = $request;
        $this->proposal_ids = $proposal_ids;
    }
}
