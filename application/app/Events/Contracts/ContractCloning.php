<?php

/** --------------------------------------------------------------------------------
 * Event fired before contract cloning execution
 * Allows modules to perform pre-action logic before contract is cloned
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Contracts;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContractCloning {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $contract_id;

    /**
     * Create a new event instance.
     * This event is fired before contract cloning execution
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $contract_id  Source contract ID
     * @return void
     */
    public function __construct($request, $contract_id) {
        $this->request = $request;
        $this->contract_id = $contract_id;
    }
}
