<?php

/** --------------------------------------------------------------------------------
 * This middleware checks the authenticated users permissions for managing subscriptions
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Landlord\Subscriptions;

use Closure;
use Log;

class Manage {

    /**
     * Check if the current user has permission to manage subscriptions
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //get the authenticated users role permissions
        $permissions = \App\Models\Landlord\Role::where('role_id', auth()->user()->role_id)->first();

        //check permission to manage subscriptions
        if ($permissions->role_permissions_subscriptions != 'manage') {
            Log::error("permission denied - the user does not have permission for this action", ['process' => 'middleware.landlord.subscriptions.manage', 'ref' => config('app.debug_ref'), 'file' => basename(__FILE__), 'line' => __line__]);
            abort(403);
        }

        return $next($request);
    }
}
