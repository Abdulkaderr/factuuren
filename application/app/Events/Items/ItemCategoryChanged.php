<?php

/** --------------------------------------------------------------------------------
 * Event fired after category update, before response
 * Allows modules to react to item category changes
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Items;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ItemCategoryChanged {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $item_ids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after category update, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $item_ids  Array of item IDs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $item_ids, $payload) {
        $this->request = $request;
        $this->item_ids = $item_ids;
        $this->payload = $payload;
    }
}
