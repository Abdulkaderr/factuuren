<?php

/** --------------------------------------------------------------------------------
 * Event fired after email sent, before response
 * Allows modules to perform post-action logic after contract email is resent
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Contracts;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContractEmailResent {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $contract_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after email sent, before response
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
