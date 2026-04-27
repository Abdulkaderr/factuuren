<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before automation update
 * Allows modules to perform pre-action logic before proposal automation is updated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Proposals;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProposalAutomationUpdating {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $proposal_id;

    /**
     * Create a new event instance.
     * This event is fired after validation, before automation update
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $proposal_id  Proposal ID
     * @return void
     */
    public function __construct($request, $proposal_id) {
        $this->request = $request;
        $this->proposal_id = $proposal_id;
    }
}
