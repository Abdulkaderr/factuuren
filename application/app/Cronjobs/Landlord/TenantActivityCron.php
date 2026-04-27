<?php

/** ---------------------------------------------------------------------------------------------------
 * Updates tenant activity status based on last seen timestamp
 * Status values: active (≤7 days), dormant (8-30 days), inactive (>30 days), none (never logged in)
 *
 * @package    Grow CRM
 * @author     NextLoop
 *-----------------------------------------------------------------------------------------------------*/

namespace App\Cronjobs\Landlord;

use Illuminate\Support\Facades\Log;

class TenantActivityCron {

    public function __invoke() {

        //[MT] - run this cron for landlord only
        if (env('MT_TPYE')) {
            if (\Spatie\Multitenancy\Models\Tenant::current()) {
                return;
            }
        }

        //boot config settings for landlord
        runtimeLandlordCronConfig();

        //update tenant activity statuses
        $this->updateActivityStatuses();
    }

    /**
     * Update tenant activity status based on last seen timestamp
     * - active: last seen within 7 days
     * - dormant: last seen 8-30 days ago
     * - inactive: last seen more than 30 days ago
     * - none: never logged in
     *
     * @return void
     */
    private function updateActivityStatuses() {

        Log::info("Tenant activity status update - started", ['process' => '[landlord-cronjob][tenant-activity-cron]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);

        //date thresholds
        $seven_days_ago = \Carbon\Carbon::now()->subDays(7)->format('Y-m-d H:i:s');
        $thirty_days_ago = \Carbon\Carbon::now()->subDays(30)->format('Y-m-d H:i:s');

        //update tenants with no activity to 'none'
        \App\Models\Landlord\Tenant::on('landlord')
            ->whereNull('tenant_tracking_activity_last_seen')
            ->update(['tenant_activity_status' => 'none']);

        //update active tenants (last seen within 7 days)
        \App\Models\Landlord\Tenant::on('landlord')
            ->whereNotNull('tenant_tracking_activity_last_seen')
            ->where('tenant_tracking_activity_last_seen', '>=', $seven_days_ago)
            ->update(['tenant_activity_status' => 'active']);

        //update dormant tenants (last seen 8-30 days ago)
        \App\Models\Landlord\Tenant::on('landlord')
            ->whereNotNull('tenant_tracking_activity_last_seen')
            ->where('tenant_tracking_activity_last_seen', '<', $seven_days_ago)
            ->where('tenant_tracking_activity_last_seen', '>=', $thirty_days_ago)
            ->update(['tenant_activity_status' => 'dormant']);

        //update inactive tenants (last seen more than 30 days ago)
        \App\Models\Landlord\Tenant::on('landlord')
            ->whereNotNull('tenant_tracking_activity_last_seen')
            ->where('tenant_tracking_activity_last_seen', '<', $thirty_days_ago)
            ->update(['tenant_activity_status' => 'inactive']);

        Log::info("Tenant activity status update - completed", ['process' => '[landlord-cronjob][tenant-activity-cron]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
    }

}
