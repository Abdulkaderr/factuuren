<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before lead import execution
 * Allows modules to perform pre-action logic before leads are imported
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Import\Leads;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadImportStoring {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;

    /**
     * Create a new event instance.
     * This event is fired after validation, before lead import execution
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @return void
     */
    public function __construct($request) {
        $this->request = $request;
    }
}
