<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before acceptance processing
 * Allows modules to perform pre-action logic before proposal is accepted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Proposals;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProposalAccepting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $proposal_id;

    /**
     * Create a new event instance.
     * This event is fired after validation, before acceptance processing
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
