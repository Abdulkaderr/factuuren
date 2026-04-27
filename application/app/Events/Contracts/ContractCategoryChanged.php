<?php

/** --------------------------------------------------------------------------------
 * Event fired after category update, before response
 * Allows modules to perform post-action logic after contract category is changed
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Contracts;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContractCategoryChanged {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $contract_ids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after category update, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $contract_ids  Array of contract IDs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $contract_ids, $payload) {
        $this->request = $request;
        $this->contract_ids = $contract_ids;
        $this->payload = $payload;
    }
}
