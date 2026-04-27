<?php

/** --------------------------------------------------------------------------------
 * Event fired before contract deletion
 * Allows modules to perform pre-action logic before contracts are deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Contracts;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContractDeleting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $contract_ids;

    /**
     * Create a new event instance.
     * This event is fired before contract deletion
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $contract_ids  Array of contract IDs to be deleted
     * @return void
     */
    public function __construct($request, $contract_ids) {
        $this->request = $request;
        $this->contract_ids = $contract_ids;
    }
}
