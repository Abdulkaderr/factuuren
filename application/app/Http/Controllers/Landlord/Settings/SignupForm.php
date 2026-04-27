<?php

/** --------------------------------------------------------------------------------
 * This controller manages all the business logic for signup form settings
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Controllers\Landlord\Settings;

use App\Http\Controllers\Controller;
use App\Http\Responses\Landlord\Settings\SignupForm\ShowResponse;
use Validator;

class SignupForm extends Controller {

    public function __construct() {

        //parent
        parent::__construct();

        //authenticated
        $this->middleware('auth');

    }

    /**
     * Display the signup form settings page
     * @return blade view | ajax view
     */
    public function show() {

        //get settings
        $settings = \App\Models\Landlord\Settings::Where('settings_id', 'default')->first();

        //reponse payload
        $payload = [
            'page' => $this->pageSettings('index'),
            'settings' => $settings,
            'section' => 'signup-form',
        ];

        //show the form
        return new ShowResponse($payload);
    }

    /**
     * Update the signup form settings
     * @return \Illuminate\Http\Response
     */
    public function update() {

        //custom error messages
        $messages = [
            'settings_signup_form_country.in'   => __('lang.country') . ' - ' . __('lang.is_required'),
            'settings_signup_form_telephone.in' => __('lang.telephone') . ' - ' . __('lang.is_required'),
        ];

        //validate
        $validator = Validator::make(request()->all(), [
            'settings_signup_form_country'   => ['required', 'in:required,optional,not-included'],
            'settings_signup_form_telephone' => ['required', 'in:required,optional,not-included'],
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

        //update settings
        \App\Models\Landlord\Settings::where('settings_id', 'default')
            ->update([
                'settings_signup_form_country'   => request('settings_signup_form_country'),
                'settings_signup_form_telephone' => request('settings_signup_form_telephone'),
            ]);

        $jsondata['redirect_url'] = url('/app-admin/settings/signup-form');

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
                __('lang.signup_form_settings'),
            ],
            'crumbs_special_class' => 'list-pages-crumbs',
            'meta_title' => __('lang.settings'),
            'heading' => __('lang.settings'),
            'page' => 'landlord-settings',
            'mainmenu_settings' => 'active',
            'inner_menu_signup_form' => 'active',
        ];

        //show
        config(['visibility.left_inner_menu' => 'settings']);

        //return
        return $page;
    }
}
