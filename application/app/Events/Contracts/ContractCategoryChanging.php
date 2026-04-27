<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before category update
 * Allows modules to perform pre-action logic before contract category is changed
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Contracts;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContractCategoryChanging {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $contract_ids;

    /**
     * Create a new event instance.
     * This event is fired after validation, before category update
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
