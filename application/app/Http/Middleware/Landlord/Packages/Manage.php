<?php

/** --------------------------------------------------------------------------------
 * This middleware checks the authenticated users permissions to manage packages
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Landlord\Packages;

use Closure;
use Log;

class Manage {

    /**
     * Check if the current user has permission to manage packages
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //get the authenticated users role permissions
        $permissions = \App\Models\Landlord\Role::where('role_id', auth()->user()->role_id)->first();

        //check permission to manage packages
        if ($permissions->role_permissions_plans != 'manage') {
            Log::error("permission denied - the user does not have permission for this action", ['process' => 'middleware.landlord.packages.manage', 'ref' => config('app.debug_ref'), 'file' => basename(__FILE__), 'line' => __line__]);
            abort(403);
        }

        return $next($request);
    }
}
