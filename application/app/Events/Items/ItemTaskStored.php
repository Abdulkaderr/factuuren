<?php

/** --------------------------------------------------------------------------------
 * Event fired after task creation, before response
 * Allows modules to save their custom data after the task has been created
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Items;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ItemTaskStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $product_task_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after task creation, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $product_task_id  Created task ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $product_task_id, $payload) {
        $this->request = $request;
        $this->product_task_id = $product_task_id;
        $this->payload = $payload;
    }
}
