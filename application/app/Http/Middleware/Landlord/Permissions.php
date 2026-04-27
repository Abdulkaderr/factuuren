<?php

/** --------------------------------------------------------------------------------
 * This middleware sets menu visibility config keys based on the authenticated
 * users role permissions. It runs on every landlord request.
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Landlord;

use Closure;

class Permissions {

    /**
     * Set menu visibility config keys for the authenticated user
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //only run for authenticated users
        if (auth()->check()) {

            //get the authenticated users role permissions
            if ($permissions = \App\Models\Landlord\Role::where('role_id', auth()->user()->role_id)->first()) {
                $this->setMenuVisibility($permissions);
            }
        }

        return $next($request);
    }

    /*
     * set left menu visibility based on role permissions
     */
    private function setMenuVisibility($permissions) {

        //customers menu item
        if (in_array($permissions->role_permissions_customers, ['view', 'manage'])) {
            config(['visibility.menu_customers' => true]);
        }

        //packages menu item
        if (in_array($permissions->role_permissions_plans, ['view', 'manage'])) {
            config(['visibility.menu_packages' => true]);
        }

        //subscriptions menu item
        if (in_array($permissions->role_permissions_subscriptions, ['view', 'manage'])) {
            config(['visibility.menu_subscriptions' => true]);
        }

        //payments menu item (online and offline)
        if (in_array($permissions->role_permissions_payments, ['view', 'manage'])) {
            config(['visibility.menu_payments' => true]);
        }

        //events menu item
        if (in_array($permissions->role_permissions_global_events, ['view', 'manage'])) {
            config(['visibility.menu_events' => true]);
        }

        //team menu item
        if (in_array($permissions->role_permissions_team, ['view', 'manage'])) {
            config(['visibility.menu_team' => true]);
        }

        //settings menu item
        if (in_array($permissions->role_permissions_settings, ['view', 'manage'])) {
            config(['visibility.menu_settings' => true]);
        }
    }
}
