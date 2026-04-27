<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before category update
 * Allows modules to perform pre-action logic before category is updated
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Categories;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CategoryUpdating {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $category_id;

    /**
     * Create a new event instance.
     * This event is fired after validation, before category update
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  int  $category_id  Category ID
     * @return void
     */
    public function __construct($request, $category_id) {
        $this->request = $request;
        $this->category_id = $category_id;
    }
}
