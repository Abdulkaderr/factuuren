<?php

/** --------------------------------------------------------------------------------
 * Event fired after signature file is created and trimmed
 * Allows modules to perform additional processing on signature files
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Proposals;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProposalSignatureSaved {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $signature_path;

    /**
     * Create a new event instance.
     * This event is fired after signature file is created and trimmed
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $signature_path  Signature file path information array
     * @return void
     */
    public function __construct($request, $signature_path) {
        $this->request = $request;
        $this->signature_path = $signature_path;
    }
}
