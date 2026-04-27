<?php

/** --------------------------------------------------------------------------------
 * Event fired after team member update and project reassignment, before response
 * Allows modules to perform actions after category team has been updated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Categories;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CategoryTeamUpdated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $category_id;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after team member update and project reassignment, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  int  $category_id  Category ID
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $category_id, $payload) {
        $this->request = $request;
        $this->category_id = $category_id;
        $this->payload = $payload;
    }
}
