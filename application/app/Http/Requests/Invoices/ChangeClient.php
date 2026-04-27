<?php

/** --------------------------------------------------------------------------------
 * This middleware class validates input requests for the invoices controller
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Requests\Invoices;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeClient extends FormRequest {

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
            'bill_clientid.exists' => __('lang.client_not_found'),
        ];
    }

    /**
     * Validate the request
     * @return array
     */
    public function rules() {

        $rules = [
            'bill_clientid' => [
                'required',
                Rule::exists('clients', 'client_id'),
            ],
        ];

        return $rules;
    }

    /**
     * Deal with the errors
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
