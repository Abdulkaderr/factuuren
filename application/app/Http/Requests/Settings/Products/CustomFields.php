<?php

/** --------------------------------------------------------------------------------
 * This middleware class validates input requests for the product custom fields controller
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Requests\Settings\Products;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CustomFields extends FormRequest {

    /**
     * Authorize the request
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Validation rules
     *
     * @return array
     */
    public function rules() {

        $rules = [
            'items_custom_field_name.*' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];

        return $rules;
    }

    /**
     * Custom error messages
     *
     * @return array
     */
    public function messages() {
        return [
            'items_custom_field_name.*.max' => __('lang.field_name') . ' - ' . __('lang.maximum_255_characters'),
        ];
    }

    /**
     * Handle failed validation
     *
     * @param Validator $validator
     * @return void
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
