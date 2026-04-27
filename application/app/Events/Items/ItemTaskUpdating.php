<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before task update
 * Allows modules to perform pre-action logic before task is updated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Items;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ItemTaskUpdating {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $product_task_id;

    /**
     * Create a new event instance.
     * This event is fired after validation, before task update
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $product_task_id  Task ID
     * @return void
     */
    public function __construct($request, $product_task_id) {
        $this->request = $request;
        $this->product_task_id = $product_task_id;
    }
}
