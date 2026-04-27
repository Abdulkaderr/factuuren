<?php

/** --------------------------------------------------------------------------------
 * Event fired after expense cloning, before response
 * Allows modules to clone their custom data after the expense has been cloned
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Expenses;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExpenseCloned {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $source_expense_id;
    public $new_expense_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after expense cloning, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $source_expense_id  Source expense ID
     * @param  int  $new_expense_id  Cloned expense ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $source_expense_id, $new_expense_id, $payload) {
        $this->request = $request;
        $this->source_expense_id = $source_expense_id;
        $this->new_expense_id = $new_expense_id;
        $this->payload = $payload;
    }
}
