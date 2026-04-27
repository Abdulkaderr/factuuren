<?php

/** --------------------------------------------------------------------------------
 * This controller manages all the business logic for maintenance mode settings
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Controllers\Landlord\Settings;

use App\Http\Controllers\Controller;
use App\Http\Responses\Landlord\Settings\Maintenance\ShowResponse;
use Validator;

class Maintenance extends Controller {

    public function __construct() {

        //parent
        parent::__construct();

        //authenticated
        $this->middleware('auth');

    }

    /**
     * Display the maintenance mode settings page
     * @return blade view | ajax view
     */
    public function show() {

        //get settings
        $settings = \App\Models\Landlord\Settings::Where('settings_id', 'default')->first();

        //reponse payload
        $payload = [
            'page' => $this->pageSettings('index'),
            'settings' => $settings,
            'section' => 'maintenance',
        ];

        //show the form
        return new ShowResponse($payload);
    }

    /**
     * Update maintenance mode settings
     * @return \Illuminate\Http\Response
     */
    public function update() {

        //custom error messages
        $messages = [
            'settings_maintenace_mode_status.required' => __('lang.maintenance_mode_status') . ' - ' . __('lang.is_required'),
            'html_settings_maintenace_mode_message.required_if' => __('lang.maintenance_mode_message') . ' - ' . __('lang.is_required'),
        ];

        //validate
        $validator = Validator::make(request()->all(), [
            'settings_maintenace_mode_status' => [
                'required',
            ],
            'html_settings_maintenace_mode_message' => [
                'required_if:settings_maintenace_mode_status,enabled',
            ],
        ], $messages);

        //errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $messages = '';
            foreach ($errors->all() as $message) {
                $messages .= "<li>$message</li>";
            }
            abort(409, $messages);
        }

        //get settings
        $settings = \App\Models\Landlord\Settings::Where('settings_id', 'default')->first();

        //update settings
        \App\Models\Landlord\Settings::where('settings_id', 'default')
            ->update([
                'settings_maintenace_mode_status'  => request('settings_maintenace_mode_status'),
                'settings_maintenace_mode_message' => request('html_settings_maintenace_mode_message'),
            ]);

        $jsondata['redirect_url'] = url('/app-admin/settings/maintenance');

        request()->session()->flash('success-notification-long', __('lang.request_has_been_completed'));

        //ajax response
        return response()->json($jsondata);
    }

    /**
     * basic page setting for this section of the app
     * @param string $section page section (optional)
     * @param array $data any other data (optional)
     * @return array
     */
    private function pageSettings($section = '', $data = []) {

        //common settings
        $page = [
            'crumbs' => [
                __('lang.settings'),
                __('lang.maintenance_mode'),
            ],
            'crumbs_special_class' => 'list-pages-crumbs',
            'meta_title' => __('lang.settings'),
            'heading' => __('lang.settings'),
            'page' => 'landlord-settings',
            'mainmenu_settings' => 'active',
            'inner_group_menu_debugging' => 'active',
            'inner_menu_maintenance' => 'active',
        ];

        //show
        config(['visibility.left_inner_menu' => 'settings']);

        //return
        return $page;
    }
}
