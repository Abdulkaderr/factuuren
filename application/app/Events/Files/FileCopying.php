<?php

/** --------------------------------------------------------------------------------
 * Event fired after validation, before file copying
 * Allows modules to perform pre-action logic before files are copied
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Files;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileCopying {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $file_ids;

    /**
     * Create a new event instance.
     * This event is fired after validation, before file copying
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request object
     * @param  array  $file_ids  Array of source file IDs
     * @return void
     */
    public function __construct($request, $file_ids) {
        $this->request = $request;
        $this->file_ids = $file_ids;
    }
}
