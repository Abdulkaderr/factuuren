<?php

/** --------------------------------------------------------------------------------
 * Event fired before bulk deletion execution
 * Allows modules to perform pre-action logic before contracts are bulk deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Contracts;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContractBulkDeleting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $contract_ids;

    /**
     * Create a new event instance.
     * This event is fired before bulk deletion execution
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $contract_ids  Array of contract IDs
     * @return void
     */
    public function __construct($request, $contract_ids) {
        $this->request = $request;
        $this->contract_ids = $contract_ids;
    }
}
