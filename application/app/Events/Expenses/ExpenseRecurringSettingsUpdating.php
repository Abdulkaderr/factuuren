<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before settings update
 * Allows modules to perform pre-action logic before recurring settings are updated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Expenses;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExpenseRecurringSettingsUpdating {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $expense_id;

    /**
     * Create a new event instance.
     * This event is fired after validation, before settings update
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $expense_id  Expense ID
     * @return void
     */
    public function __construct($request, $expense_id) {
        $this->request = $request;
        $this->expense_id = $expense_id;
    }
}
