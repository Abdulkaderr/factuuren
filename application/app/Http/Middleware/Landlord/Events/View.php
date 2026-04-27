<?php

/** --------------------------------------------------------------------------------
 * This middleware checks the authenticated users permissions for viewing events
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Landlord\Events;

use Closure;
use Log;

class View {

    /**
     * Check if the current user has permission to view events
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //get the authenticated users role permissions
        $permissions = \App\Models\Landlord\Role::where('role_id', auth()->user()->role_id)->first();

        //check permission to view events
        if (!in_array($permissions->role_permissions_global_events, ['view', 'manage'])) {
            Log::error("permission denied - the user does not have permission for this action", ['process' => 'middleware.landlord.events.view', 'ref' => config('app.debug_ref'), 'file' => basename(__FILE__), 'line' => __line__]);
            abort(403);
        }

        return $next($request);
    }
}
