<?php

/** --------------------------------------------------------------------------------
 * Event fired after category update, before response
 * Allows modules to react to proposal category changes
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Proposals;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProposalCategoryChanged {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $proposal_ids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after category update, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  array  $proposal_ids  Array of updated proposal IDs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $proposal_ids, $payload) {
        $this->request = $request;
        $this->proposal_ids = $proposal_ids;
        $this->payload = $payload;
    }
}
