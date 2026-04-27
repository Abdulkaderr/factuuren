<?php

/** ---------------------------------------------------------------------------------------------
 * This event does not pass or process any data. It is fired when the landlord layout wrapper is rendered
 * Its main purpose is to give modules the ability to push @stack content to various parts of the landlord application
 * ---------------------------------------------------------------------------------------------*/
namespace App\Events\Settings\ViewComposer;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Log;

class ViewRendering {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct() {

        // This event does not handle any data
        Log::info("[debug][App\Events\Settings\ViewComposer\ViewRendering] has fired");

    }
}
