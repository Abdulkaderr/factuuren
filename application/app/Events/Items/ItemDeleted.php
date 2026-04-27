<?php

/** --------------------------------------------------------------------------------
 * Event fired after item deletion, before response
 * Allows modules to perform cleanup after item has been deleted
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Items;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ItemDeleted {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $item_ids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after item deletion, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $item_ids  Array of deleted item IDs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $item_ids, $payload) {
        $this->request = $request;
        $this->item_ids = $item_ids;
        $this->payload = $payload;
    }
}
