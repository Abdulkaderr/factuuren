<?php

/** --------------------------------------------------------------------------------
 * Event fired when contract show page is being rendered
 * Allows modules to extend the page with additional data and blade stacks
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Contracts\Responses;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContractShow {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $payload;
    public $view;

    /**
     * Create a new event instance.
     * This event is fired before the contract show page is rendered,
     * allowing modules to modify the payload data and inject blade stacks
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $payload  Reference to the page data array (document, estimate, customfields, etc.)
     * @param  string  $view  The view being rendered
     * @return void
     */
    public function __construct($request, &$payload, $view) {
        $this->request = $request;
        $this->payload = &$payload;
        $this->view = $view;
    }
}
