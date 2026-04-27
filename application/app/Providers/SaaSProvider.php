<?php

namespace App\Providers;

use App\Http\ViewComposers\SaaS\MainApp\AuthShowComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Log;

class SaaSProvider extends ServiceProvider {

    public function register() {
        //
    }

    public function boot() {
        
        // Register landlord views
        $this->mainAppShowing();
    }

    /**
     * process the request
     *
     * @return bool
     */
    public function mainAppShowing() {

        // Register view composer for landlord layout
        View::composer('landlord.layout.wrapper', AuthShowComposer::class);

        // Register view composer for landlord layout
        View::composer('frontend.layout.header', AuthShowComposer::class);

    }

}