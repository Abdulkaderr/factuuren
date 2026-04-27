<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [destroy] precheck processes for refunds
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Refunds;

use Closure;
use Log;

class Destroy {

    /**
     * Check that the user has permission to delete refunds
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //for a single item DELETE request — merge into ids[] array as if a checkbox was checked
        if (is_numeric($request->route('refund'))) {
            $ids[$request->route('refund')] = 'on';
            request()->merge([
                'ids' => $ids,
            ]);
        }

        //permission: team members with payments role >= 3
        if (auth()->user()->is_team) {
            if (auth()->user()->role->role_payments >= 3) {
                return $next($request);
            }
        }

        //permission denied
        Log::error("permission denied", ['process' => '[permissions][refunds][destroy]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }
}
