<?php

/** --------------------------------------------------------------------------------
 * Event fired after scheduling completion, before response
 * Allows modules to perform post-action logic after contract publish is scheduled
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Contracts;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContractPublishScheduled {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $contract_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after scheduling completion, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $contract_id  Contract ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $contract_id, $payload) {
        $this->request = $request;
        $this->contract_id = $contract_id;
        $this->payload = $payload;
    }
}
