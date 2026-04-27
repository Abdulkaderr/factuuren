<?php

/** --------------------------------------------------------------------------------
 * Event fired before expense cloning
 * Allows modules to perform pre-action logic before expense is cloned
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Expenses;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExpenseCloning {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $expense_id;

    /**
     * Create a new event instance.
     * This event is fired before expense cloning
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $expense_id  Source expense ID
     * @return void
     */
    public function __construct($request, $expense_id) {
        $this->request = $request;
        $this->expense_id = $expense_id;
    }
}
