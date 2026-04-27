<?php

/** --------------------------------------------------------------------------------
 * This middleware restricts access to administrator-only sections.
 * Only users with role_id = 1 (Administrator) are permitted.
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Landlord;

use Closure;
use Log;

class AdminOnly {

    /**
     * Check if the current user is an Administrator
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //check if user is an administrator (role_id = 1)
        if (auth()->user()->role_id != 1) {
            Log::error("permission denied - the user does not have permission for this action", ['process' => 'middleware.landlord.admin-only', 'ref' => config('app.debug_ref'), 'file' => basename(__FILE__), 'line' => __line__]);
            abort(403);
        }

        return $next($request);
    }
}
