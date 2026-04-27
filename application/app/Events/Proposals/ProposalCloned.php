<?php

/** --------------------------------------------------------------------------------
 * Event fired after clone creation, before response
 * Allows modules to copy additional data to the cloned proposal
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Proposals;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProposalCloned {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $source_proposal_id;
    public $new_proposal_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after clone creation, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $source_proposal_id  Original proposal ID
     * @param  int  $new_proposal_id  Newly created proposal ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $source_proposal_id, $new_proposal_id, $payload) {
        $this->request = $request;
        $this->source_proposal_id = $source_proposal_id;
        $this->new_proposal_id = $new_proposal_id;
        $this->payload = $payload;
    }
}
