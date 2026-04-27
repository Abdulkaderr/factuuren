<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before project attachment
 * Allows modules to perform pre-action logic before project is attached to contract
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Contracts;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContractProjectAttaching {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $contract_id;

    /**
     * Create a new event instance.
     * This event is fired after validation, before project attachment
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $contract_id  Contract ID
     * @return void
     */
    public function __construct($request, $contract_id) {
        $this->request = $request;
        $this->contract_id = $contract_id;
    }
}
