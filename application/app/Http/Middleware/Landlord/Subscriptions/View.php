<?php

/** --------------------------------------------------------------------------------
 * This middleware checks the authenticated users permissions for viewing subscriptions
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Landlord\Subscriptions;

use Closure;
use Log;

class View {

    /**
     * Check if the current user has permission to view subscriptions
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //get the authenticated users role permissions
        $permissions = \App\Models\Landlord\Role::where('role_id', auth()->user()->role_id)->first();

        //frontend
        $this->fronteEnd($permissions);

        //check permission to view subscriptions
        if (!in_array($permissions->role_permissions_subscriptions, ['view', 'manage'])) {
            Log::error("permission denied - the user does not have permission for this action", ['process' => 'middleware.landlord.subscriptions.view', 'ref' => config('app.debug_ref'), 'file' => basename(__FILE__), 'line' => __line__]);
            abort(403);
        }

        return $next($request);
    }

    /*
     * various frontend related settings
     */
    private function fronteEnd($permissions) {

        //subscription management buttons (cancel, delete)
        if ($permissions->role_permissions_subscriptions == 'manage') {
            config([
                'visibility.resource_management' => true,
            ]);
        }
    }
}
