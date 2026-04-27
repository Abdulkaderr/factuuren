<?php

/** ---------------------------------------------------------------------------------------------
 * View Composer for the landlord layout wrapper
 * Fires the AppShow event to allow modules to push content to blade stacks
 * ---------------------------------------------------------------------------------------------*/

namespace App\Http\ViewComposers\MainApp;

use App\Events\MainApp\ViewComposer\ViewRendering;

use Illuminate\View\View;
use Log;


class Rendering {

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view) {
        
        Log::info("[debug][App\Http\ViewComposers\MainApp\Rendering] has fired");

        // Fire event to indicate the view has been rendered
        event(new ViewRendering());
    }
}
