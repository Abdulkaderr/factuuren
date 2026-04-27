<?php

/** --------------------------------------------------------------------------------
 * Event fired after automation settings are applied, before method completion
 * Allows modules to react to default automation being applied to new proposal
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Proposals;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProposalAutomationApplied {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $proposal_id;

    /**
     * Create a new event instance.
     * This event is fired after automation settings are applied, before method completion
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $proposal_id  Proposal ID (doc_id)
     * @return void
     */
    public function __construct($request, $proposal_id) {
        $this->request = $request;
        $this->proposal_id = $proposal_id;
    }
}
