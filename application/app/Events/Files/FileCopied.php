<?php

/** --------------------------------------------------------------------------------
 * Event fired after file copying, before response
 * Allows modules to save their custom data after files have been copied
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Files;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileCopied {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $source_file_ids;
    public $new_file_ids;
    public $payload;

    /**
     * Create a new event instance.
     * This event is fired after file copying, before response
     *
     * @param  \Illuminate\Http\Request  $request  Original HTTP request
     * @param  array  $source_file_ids  Array of source file IDs
     * @param  array  $new_file_ids  Array of newly created file IDs
     * @param  array  $payload  Response data array
     * @return void
     */
    public function __construct($request, $source_file_ids, $new_file_ids, $payload) {
        $this->request = $request;
        $this->source_file_ids = $source_file_ids;
        $this->new_file_ids = $new_file_ids;
        $this->payload = $payload;
    }
}
