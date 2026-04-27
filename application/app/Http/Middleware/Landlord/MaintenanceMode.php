<?php

/** --------------------------------------------------------------------------------
 * Checks if the system is in maintenance mode and intercepts tenant requests.
 * Queries the landlord settings and returns the maintenance page if enabled.
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Landlord;

use Closure;
use Log;

class MaintenanceMode {

    /**
     * Check maintenance mode status and block tenant access if enabled
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        try {
            //query landlord settings using explicit landlord connection
            $settings = \App\Models\Landlord\Settings::on('landlord')->Where('settings_id', 'default')->first();

            //if maintenance mode is enabled, return the maintenance page
            if ($settings && $settings->settings_maintenace_mode_status === 'enabled') {
                return response()->view('landlord.settings.sections.maintenance.display', [
                    'message' => $settings->settings_maintenace_mode_message,
                ], 503);
            }

        } catch (\Exception $e) {
            //fail silently - do not block access if settings cannot be read
            Log::error("maintenance mode check failed", ['process' => 'MaintenanceMode.handle', config('app.debug_ref'), basename(__FILE__), __LINE__]);
        }

        return $next($request);
    }
}
