<?php

/** --------------------------------------------------------------------------------
 * This middleware checks the authenticated users permissions for viewing packages
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Landlord\Packages;

use Closure;
use Log;

class View {

    /**
     * Check if the current user has permission to view packages
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //get the authenticated users role permissions
        $permissions = \App\Models\Landlord\Role::where('role_id', auth()->user()->role_id)->first();

        //frontend
        $this->fronteEnd($permissions);

        //check permission to view packages
        if (!in_array($permissions->role_permissions_plans, ['view', 'manage'])) {
            Log::error("permission denied - the user does not have permission for this action", ['process' => 'middleware.landlord.packages.view', 'ref' => config('app.debug_ref'), 'file' => basename(__FILE__), 'line' => __line__]);
            abort(403);
        }

        return $next($request);
    }

    /*
     * various frontend related settings
     */
    private function fronteEnd($permissions) {

        //package management buttons (add, edit, archive, restore, delete)
        if ($permissions->role_permissions_plans == 'manage') {
            config([
                'visibility.resource_management' => true,
            ]);
        }
    }
}
