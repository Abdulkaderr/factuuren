<?php

/** --------------------------------------------------------------------------------
 * This middleware checks the authenticated users permissions for viewing a
 * customer's platform usage tab
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Landlord\Customers;

use Closure;
use Log;

class ViewPlatformUsage {

    /**
     * Check if the current user has permission to view the customer platform usage tab
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //get the authenticated users role permissions
        $permissions = \App\Models\Landlord\Role::where('role_id', auth()->user()->role_id)->first();

        //check permission to view customer platform usage
        if (!in_array($permissions->role_permissions_customer_platform_usage, ['view', 'manage'])) {
            Log::error("permission denied - the user does not have permission for this action", ['process' => 'middleware.landlord.customers.view-platform-usage', 'ref' => config('app.debug_ref'), 'file' => basename(__FILE__), 'line' => __line__]);
            abort(403);
        }

        return $next($request);
    }
}
