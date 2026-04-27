<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [index] precheck processes for refunds
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Refunds;

use Closure;
use Log;

class Index {

    /**
     * This middleware does the following:
     *   1. Checks user permissions to view refunds
     *   2. Sets frontend visibility configs
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //validate module status — refunds are gated behind the payments module
        if (!config('visibility.modules.payments')) {
            abort(404, __('lang.the_requested_service_not_found'));
            return $next($request);
        }

        //various frontend and visibility settings
        $this->fronteEnd();

        //permission: team members with payments role >= 1
        if (auth()->user()->is_team) {
            if (auth()->user()->role->role_payments >= 1) {
                return $next($request);
            }
        }

        //permission denied
        Log::error("permission denied", ['process' => '[permissions][refunds][index]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }

    /*
     * Set frontend visibility configs — mirrors the payments role permission structure
     */
    private function fronteEnd() {

        //viewing permissions (role >= 1)
        if (auth()->user()->role->role_payments >= 1) {
            config([
                'visibility.refunds_col_action'              => true,
                'visibility.refunds_col_tags'                => true,
                'visibility.list_page_actions_search'        => true,
                'visibility.list_page_actions_filter_button' => true,
            ]);
        }

        //add/edit permissions (role >= 2)
        if (auth()->user()->role->role_payments >= 2) {
            config([
                'visibility.list_page_actions_add_button' => true,
                'visibility.action_buttons_edit'          => true,
                'visibility.refunds_col_checkboxes'       => true,
            ]);
        }

        //delete permissions (role >= 3)
        if (auth()->user()->role->role_payments >= 3) {
            config([
                'visibility.action_buttons_delete' => true,
            ]);
        }
    }
}
