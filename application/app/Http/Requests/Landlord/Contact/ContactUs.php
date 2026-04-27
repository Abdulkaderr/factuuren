<?php

/** --------------------------------------------------------------------------------
 * This middleware class validates input requests for the contact controller
 *
 * @package   SaaS Platform
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Requests\Landlord\Contact;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ContactUs extends FormRequest {

    /**
     * we are checking authorised users via the middleware
     * so just retun true here
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * custom error messages for specific valdation checks
     * @optional
     * @return array
     */
    public function messages() {
        return [
            'contact_name.required' => __('lang.name') . ' - ' . __('lang.is_required'),
            'contact_email.required' => __('lang.email') . ' - ' . __('lang.is_required'),
            'contact_email.email' => __('lang.email') . ' - ' . __('lang.is_invalid'),
            'contact_message.required' => __('lang.message') . ' - ' . __('lang.is_required'),
            'g-recaptcha-response.recaptcha' => __('lang.recaptcha_validation_error'),
        ];
    }

    /**
     * Validate the request
     * @return array
     */
    public function rules() {

        $rules = [
            'contact_name' => [
                'required',
            ],
            'contact_email' => [
                'required',
                'email',
            ],
            'contact_message' => [
                'required',
            ],
        ];

        /**-------------------------------------------------------
         * recaptcha validation
         * ------------------------------------------------------*/
        if (config('system.settings_captcha_status') == 'enabled') {
            $rules += [
                'g-recaptcha-response' => 'recaptcha',
            ];
        }

        //validate
        return $rules;
    }

    /**
     * Deal with the errors - send messages to the frontend
     */
    public function failedValidation(Validator $validator) {

        $errors = $validator->errors();
        $messages = '';
        foreach ($errors->all() as $message) {
            $messages .= "<li>$message</li>";
        }

        abort(409, $messages);
    }
}
