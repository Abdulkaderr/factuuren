<?php

/** --------------------------------------------------------------------------------
 * Event fired after category creation, before response
 * Allows modules to save their custom data after the category has been created
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Categories;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CategoryStored {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $category_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after category creation, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $category_id  Created category ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $category_id, $payload) {
        $this->request = $request;
        $this->category_id = $category_id;
        $this->payload = $payload;
    }
}
