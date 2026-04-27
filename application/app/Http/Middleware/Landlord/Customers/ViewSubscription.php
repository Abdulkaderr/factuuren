<?php

/** --------------------------------------------------------------------------------
 * This middleware checks the authenticated users permissions for viewing a customer subscription
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Landlord\Customers;

use Closure;
use Log;

class ViewSubscription {

    /**
     * Check if the current user has permission to view a customer subscription
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //get the authenticated users role permissions
        $permissions = \App\Models\Landlord\Role::where('role_id', auth()->user()->role_id)->first();

        //check permission to view customer subscription
        if (!in_array($permissions->role_permissions_customer_subscription, ['view', 'manage'])) {
            Log::error("permission denied - the user does not have permission for this action", ['process' => 'middleware.landlord.customers.view-subscription', 'ref' => config('app.debug_ref'), 'file' => basename(__FILE__), 'line' => __line__]);
            abort(403);
        }

        return $next($request);
    }
}
