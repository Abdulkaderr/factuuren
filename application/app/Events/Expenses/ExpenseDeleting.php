<?php

/** --------------------------------------------------------------------------------
 * Event fired before expense deletion
 * Allows modules to perform cleanup or validation before expense is deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Expenses;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExpenseDeleting {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $expense_ids;

    /**
     * Create a new event instance.
     * This event is fired before expense deletion
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $expense_ids  Array of expense IDs
     * @return void
     */
    public function __construct($request, $expense_ids) {
        $this->request = $request;
        $this->expense_ids = $expense_ids;
    }
}
