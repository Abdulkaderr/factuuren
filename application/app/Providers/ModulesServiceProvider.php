<?php

/** ---------------------------------------------------------------------------------
 * ModulesServiceProvider
 * Business logic related to modules
 * @source Nextloop
 *-----------------------------------------------------------------------------------*/

namespace App\Providers;

use App\Http\ViewComposers\MainApp\Rendering as MainApp;
use App\Http\ViewComposers\Settings\Rendering as Settings;
use App\Http\ViewComposers\GuestApp\Rendering as GuestApp;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Log;

class ModulesServiceProvider extends ServiceProvider {

    public function register() {
        //
    }

    public function boot() {

        //main app is rendering
        $this->ViewComposerMainApp();

        // settings section is rendering
        $this->ViewComposerSettings();

        // guest app is rendering
        $this->ViewComposerGuestApp();

    }

    /**
     * The main application is being rendered/displayed
     * Register a view composer
     * View composer will trigger an event
     *
     * @return bool
     */
    public function ViewComposerMainApp() {

        //skip for ajax request
        if (request()->ajax()) {
            return;
        }

        Log::info("[debug][App\Providers\ModulesServiceProvider] - [MainApp] has fired");

        //authenticated: main app loading
        View::composer('layout.wrapper', MainApp::class);

    }

    /**
     * Guest application is being rendered/displayed
     * Register a view composer
     * View composer will trigger an event
     *
     * @return bool
     */
    public function ViewComposerGuestApp() {

        //skip for ajax request
        if (request()->ajax()) {
            return;
        }

        Log::info("[debug][App\Providers\ModulesServiceProvider] - [GuestApp] has fired");

        //guest: plain layout loading
        View::composer('layout.wrapperplain', GuestApp::class);

    }

    /**
     * Settings section is being rendered/displayed
     * Register a view composer
     * View composer will trigger an event
     *
     * @return bool
     */
    public function ViewComposerSettings() {

        //skip for ajax request
        if (request()->ajax()) {
            return;
        }

        Log::info("[debug][App\Providers\ModulesServiceProvider] - [Settings] has fired");

        //authenticated: settings loading
        View::composer('pages.settings.wrapper-settings', Settings::class);

    }

}