<?php

/** --------------------------------------------------------------------------------
 * Event fired after acceptance processing and automation trigger, before response
 * Allows modules to react to proposal acceptance
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Proposals;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProposalAccepted {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $proposal_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after acceptance processing and automation trigger, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $proposal_id  Proposal ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $proposal_id, $payload) {
        $this->request = $request;
        $this->proposal_id = $proposal_id;
        $this->payload = $payload;
    }
}
