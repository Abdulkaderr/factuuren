<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before scheduling
 * Allows modules to perform pre-action logic before contract publish is scheduled
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Contracts;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContractPublishScheduling {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $contract_id;

    /**
     * Create a new event instance.
     * This event is fired after validation, before scheduling
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
