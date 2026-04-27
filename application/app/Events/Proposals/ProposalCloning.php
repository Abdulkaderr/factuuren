<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before clone creation
 * Allows modules to perform pre-action logic before proposal is cloned
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Proposals;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProposalCloning {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $source_proposal_id;

    /**
     * Create a new event instance.
     * This event is fired after validation, before clone creation
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $source_proposal_id  Original proposal ID being cloned
     * @return void
     */
    public function __construct($request, $source_proposal_id) {
        $this->request = $request;
        $this->source_proposal_id = $source_proposal_id;
    }
}
