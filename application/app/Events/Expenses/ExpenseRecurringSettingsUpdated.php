<?php

/** --------------------------------------------------------------------------------
 * Event fired after settings update, before response
 * Allows modules to react to recurring settings changes
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Expenses;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExpenseRecurringSettingsUpdated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $expense_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after settings update, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $expense_id  Expense ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $expense_id, $payload) {
        $this->request = $request;
        $this->expense_id = $expense_id;
        $this->payload = $payload;
    }
}
