<?php

/** --------------------------------------------------------------------------------
 * Event fired after proposal creation and estimate generation, before response
 * Allows modules to save their custom data after the proposal has been created
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Proposals;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProposalStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $proposal_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after proposal creation and estimate generation, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $proposal_id  Created proposal ID (doc_id)
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $proposal_id, $payload) {
        $this->request = $request;
        $this->proposal_id = $proposal_id;
        $this->payload = $payload;
    }
}
