<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [edit] precheck processes for refunds
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Refunds;

use Closure;
use Log;

class Edit {

    /**
     * Check that the user has permission to edit refunds
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //permission: team members with payments role >= 2
        if (auth()->user()->is_team) {
            if (auth()->user()->role->role_payments >= 2) {
                return $next($request);
            }
        }

        //permission denied
        Log::error("permission denied", ['process' => '[permissions][refunds][edit]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }
}
