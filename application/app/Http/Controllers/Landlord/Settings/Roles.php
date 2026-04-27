<?php

/** --------------------------------------------------------------------------------
 * This controller manages all the business logic for roles settings
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Controllers\Landlord\Settings;

use App\Http\Controllers\Controller;
use App\Http\Responses\Landlord\Settings\Roles\ShowResponse;

class Roles extends Controller {

    public function __construct() {

        //parent
        parent::__construct();

        //authenticated
        $this->middleware('auth');

    }

    /**
     * Display the roles settings page
     * @return blade view
     */
    public function show() {

        //get admin role (role_id = 1)
        $admin_role = \App\Models\Landlord\Role::where('role_id', 1)->first();

        //get manager role (role_id = 2)
        $manager_role = \App\Models\Landlord\Role::where('role_id', 2)->first();

        //get staff role (role_id = 3)
        $staff_role = \App\Models\Landlord\Role::where('role_id', 3)->first();

        //reponse payload
        $payload = [
            'page' => $this->pageSettings('index'),
            'admin_role' => $admin_role,
            'manager_role' => $manager_role,
            'staff_role' => $staff_role,
        ];

        //show the form
        return new ShowResponse($payload);
    }

    /**
     * Update the manager and staff role permissions
     * @return json
     */
    public function update() {

        //update manager role permissions (role_id = 2)
        \App\Models\Landlord\Role::where('role_id', 2)->update([
            'role_permissions_customers'              => request('manager.role_permissions_customers'),
            'role_permissions_plans'                  => request('manager.role_permissions_plans'),
            'role_permissions_subscriptions'          => request('manager.role_permissions_subscriptions'),
            'role_permissions_payments'               => request('manager.role_permissions_payments'),
            'role_permissions_global_events'          => request('manager.role_permissions_global_events'),
            'role_permissions_customer_events'        => request('manager.role_permissions_customer_events'),
            'role_permissions_customer_notes'         => request('manager.role_permissions_customer_notes'),
            'role_permissions_customer_subscription'  => request('manager.role_permissions_customer_subscription'),
            'role_permissions_customer_payments'         => request('manager.role_permissions_customer_payments'),
            'role_permissions_customer_platform_usage'  => request('manager.role_permissions_customer_platform_usage'),
            'role_permissions_team'                      => request('manager.role_permissions_team'),
            'role_permissions_resellers'              => request('manager.role_permissions_resellers'),
            'role_permissions_settings'               => request('manager.role_permissions_settings'),
        ]);

        //update staff role permissions (role_id = 3)
        \App\Models\Landlord\Role::where('role_id', 3)->update([
            'role_permissions_customers'              => request('staff.role_permissions_customers'),
            'role_permissions_plans'                  => request('staff.role_permissions_plans'),
            'role_permissions_subscriptions'          => request('staff.role_permissions_subscriptions'),
            'role_permissions_payments'               => request('staff.role_permissions_payments'),
            'role_permissions_global_events'          => request('staff.role_permissions_global_events'),
            'role_permissions_customer_events'        => request('staff.role_permissions_customer_events'),
            'role_permissions_customer_notes'         => request('staff.role_permissions_customer_notes'),
            'role_permissions_customer_subscription'  => request('staff.role_permissions_customer_subscription'),
            'role_permissions_customer_payments'         => request('staff.role_permissions_customer_payments'),
            'role_permissions_customer_platform_usage'  => request('staff.role_permissions_customer_platform_usage'),
            'role_permissions_team'                      => request('staff.role_permissions_team'),
            'role_permissions_resellers'              => request('staff.role_permissions_resellers'),
            'role_permissions_settings'               => request('staff.role_permissions_settings'),
        ]);

        $jsondata['redirect_url'] = url('/app-admin/settings/roles');

        request()->session()->flash('success-notification-long', __('lang.request_has_been_completed'));

        //ajax response
        return response()->json($jsondata);
    }

    /**
     * Basic page settings for this section of the app
     * @param string $section page section (optional)
     * @param array $data any other data (optional)
     * @return array
     */
    private function pageSettings($section = '', $data = []) {

        //common settings
        $page = [
            'crumbs' => [
                __('lang.settings'),
                __('lang.roles'),
            ],
            'crumbs_special_class' => 'list-pages-crumbs',
            'meta_title' => __('lang.settings'),
            'heading' => __('lang.settings'),
            'page' => 'landlord-settings',
            'mainmenu_settings' => 'active',
            'inner_menu_roles' => 'active',
        ];

        //show settings left menu
        config(['visibility.left_inner_menu' => 'settings']);

        //return
        return $page;
    }
}
