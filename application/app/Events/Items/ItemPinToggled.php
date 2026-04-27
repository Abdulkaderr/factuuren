<?php

/** --------------------------------------------------------------------------------
 * Event fired after pin toggle, before response
 * Allows modules to react to item pinning state changes
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Items;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ItemPinToggled {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $item_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after pin toggle, before response
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $item_id  Item ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $item_id, $payload) {
        $this->request = $request;
        $this->item_id = $item_id;
        $this->payload = $payload;
    }
}
