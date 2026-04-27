<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before signature processing
 * Allows modules to perform pre-action logic before client signs contract
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Contracts;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContractClientSigning {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $contract_id;

    /**
     * Create a new event instance.
     * This event is fired after validation, before signature processing
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
