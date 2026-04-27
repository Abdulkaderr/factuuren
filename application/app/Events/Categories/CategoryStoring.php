<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before category creation
 * Allows modules to perform pre-action logic before category is stored
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Categories;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CategoryStoring {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;

    /**
     * Create a new event instance.
     * This event is fired after validation, before category creation
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @return void
     */
    public function __construct($request) {
        $this->request = $request;
    }
}
