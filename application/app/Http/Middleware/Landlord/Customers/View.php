<?php

/** --------------------------------------------------------------------------------
 * This middleware checks the authenticated users permissions for viewing customers
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Landlord\Customers;

use Closure;
use Log;

class View {

    /**
     * Check if the current user has permission to view customers
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //table config
        $this->tableConfig();

        //get the authenticated users role permissions
        $permissions = \App\Models\Landlord\Role::where('role_id', auth()->user()->role_id)->first();

        //frontend
        $this->fronteEnd($permissions);

        //check permission to view customers
        if (!in_array($permissions->role_permissions_customers, ['view', 'manage'])) {
            Log::error("permission denied - the user does not have permission for this action", ['process' => 'middleware.landlord.customers.view', 'ref' => config('app.debug_ref'), 'file' => basename(__FILE__), 'line' => __line__]);
            abort(403);
        }

        return $next($request);
    }

    /*
     * Set the users table column visibility preferences
     *
     * @tablename - customers
     *
     * @IMPORTANT - update the default columns here whenever new features/columns are added
     */
    private function tableConfig() {

        //get current settings or create for user
        if (!$table = \App\Models\Landlord\TableConfig::where('tableconfig_userid', auth()->id())->where('tableconfig_table_name', 'customers')->first()) {

            //create for this user and set the visible columns
            $table = new \App\Models\Landlord\TableConfig();
            $table->tableconfig_userid = auth()->id();
            $table->tableconfig_table_name = 'customers';
            $table->tableconfig_column_1 = 'displayed'; //id
            $table->tableconfig_column_2 = 'displayed'; //name
            $table->tableconfig_column_3 = 'displayed'; //created
            $table->tableconfig_column_4 = 'displayed'; //domain
            $table->tableconfig_column_5 = 'hidden'; //last_seen
            $table->tableconfig_column_6 = 'hidden'; //activity_status
            $table->tableconfig_column_7 = 'displayed'; //package_name
            $table->tableconfig_column_8 = 'displayed'; //package_type
            $table->tableconfig_column_9 = 'displayed'; //status
            $table->tableconfig_column_10 = 'hidden'; //usage - team
            $table->tableconfig_column_11 = 'hidden'; //usage - clients
            $table->tableconfig_column_12 = 'hidden'; //usage - projects
            $table->tableconfig_column_13 = 'hidden'; //usage - tasks
            $table->tableconfig_column_14 = 'hidden'; //usage - leads
            $table->tableconfig_column_15 = 'hidden'; //usage - invoices
            $table->tableconfig_column_16 = 'hidden'; //usage - estimates
            $table->tableconfig_column_17 = 'hidden'; //usage - proposals
            $table->tableconfig_column_18 = 'hidden'; //usage - contracts
            $table->tableconfig_column_19 = 'hidden'; //usage - tickets
            $table->tableconfig_column_20 = 'hidden'; //usage - emails queued
            $table->tableconfig_column_21 = 'hidden'; //usage - emails sent
            $table->tableconfig_column_22 = 'hidden'; //usage - emails processing
            $table->tableconfig_column_23 = 'hidden'; //value - invoices
            $table->tableconfig_column_24 = 'hidden'; //value - estimates
            $table->tableconfig_column_25 = 'hidden'; //value - leads converted
            $table->tableconfig_column_26 = 'hidden'; //country
            $table->tableconfig_column_27 = 'hidden'; //telephone
            $table->tableconfig_column_28 = 'hidden'; //value - payments
            $table->tableconfig_column_29 = 'hidden'; //value - proposals
            $table->tableconfig_column_30 = 'hidden'; //value - contracts
            $table->save();
        }

        //get row
        $table = \App\Models\Landlord\TableConfig::where('tableconfig_userid', auth()->id())->where('tableconfig_table_name', 'customers')->first();

        //publish table config to views
        config(['table' => $table]);

    }

    /*
     * various frontend related settings
     */
    private function fronteEnd($permissions) {

        //customer management buttons (create, edit, delete)
        if ($permissions->role_permissions_customers == 'manage') {
            config([
                'visibility.resource_management' => true,
            ]);
        }

        //customer timeline tab
        if (in_array($permissions->role_permissions_customer_events, ['view', 'manage'])) {
            config([
                'visibility.customer_tab_timeline' => true,
            ]);
        }

        //customer subscription tab and left card subscription details
        if (in_array($permissions->role_permissions_customer_subscription, ['view', 'manage'])) {
            config([
                'visibility.customer_tab_subscription' => true,
            ]);
        }

        //customer payments tab
        if (in_array($permissions->role_permissions_customer_payments, ['view', 'manage'])) {
            config([
                'visibility.customer_tab_payments' => true,
            ]);
        }

        //customer platform usage tab
        if (in_array($permissions->role_permissions_customer_platform_usage, ['view', 'manage'])) {
            config([
                'visibility.customer_tab_platform_usage' => true,
            ]);
        }

        //subscription management action buttons
        if ($permissions->role_permissions_subscriptions == 'manage') {
            config([
                'visibility.manage_subscriptions' => true,
            ]);
        }
    }
}
