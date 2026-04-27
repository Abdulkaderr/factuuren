<?php

/** --------------------------------------------------------------------------------
 * This middleware checks the authenticated users permissions for managing payments
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Landlord\Payments;

use Closure;
use Log;

class Manage {

    /**
     * Check if the current user has permission to manage payments
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //get the authenticated users role permissions
        $permissions = \App\Models\Landlord\Role::where('role_id', auth()->user()->role_id)->first();

        //check permission to manage payments
        if ($permissions->role_permissions_payments != 'manage') {
            Log::error("permission denied - the user does not have permission for this action", ['process' => 'middleware.landlord.payments.manage', 'ref' => config('app.debug_ref'), 'file' => basename(__FILE__), 'line' => __line__]);
            abort(403);
        }

        return $next($request);
    }
}
