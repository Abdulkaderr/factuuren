<?php

/** ---------------------------------------------------------------------------------------------
 * View Composer for the landlord layout wrapper
 * Fires the AppShow event to allow modules to push content to blade stacks
 * ---------------------------------------------------------------------------------------------*/

namespace App\Http\ViewComposers\SaaS\MainApp;

use App\Events\SaaS\Landlord\Responses\MainApp\AuthShow;
use Illuminate\View\View;

class AuthShowComposer {

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view) {
        
        // Fire event to indicate landlord app layout is loading
        event(new AuthShow());
    }
}
