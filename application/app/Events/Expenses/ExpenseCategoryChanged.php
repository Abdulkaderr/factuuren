<?php

/** --------------------------------------------------------------------------------
 * Event fired after category update, before response
 * Allows modules to react to category changes
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Expenses;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExpenseCategoryChanged {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $expense_ids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after category update, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $expense_ids  Array of expense IDs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $expense_ids, $payload) {
        $this->request = $request;
        $this->expense_ids = $expense_ids;
        $this->payload = $payload;
    }
}
