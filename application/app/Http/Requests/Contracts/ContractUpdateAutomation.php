<?php

/** --------------------------------------------------------------------------------
 * This middleware class validates input requests for the contracts controller
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Requests\Contracts;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ContractUpdateAutomation extends FormRequest {

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
        //custom error messages
        return [
            'contract_automation_project_title.required_if' => __('lang.project_title') . ' - ' . __('lang.is_required'),
            'contract_automation_invoice_due_date.required_if' => __('lang.automation_invoice_due_date') . ' - ' . __('lang.is_required'),
        ];
    }

    /**
     * Validate the request
     * @return array
     */
    public function rules() {

        $rules = [];

        /**-------------------------------------------------------
         * rules
         * ------------------------------------------------------*/
        if (request('contract_automation_status') == 'enabled') {
            $rules += [
                'contract_automation_project_title' => [
                    'required_if:contract_automation_create_project,on',
                ],
                'contract_automation_invoice_due_date' => [
                    'required_if:contract_automation_create_invoice,on',
                ],
                //select atleast one automation option
                'contract_automation_status' => [
                    'nullable',
                    function ($attribute, $value, $fail) {
                        if (request('contract_automation_status') == 'enabled') {
                            $selected = 0;
                            if (request('contract_automation_create_project') == 'on') {
                                $selected++;
                            }
                            if (request('contract_automation_create_invoice') == 'on') {
                                $selected++;
                            }
                            //check
                            if ($selected == 0) {
                                return $fail(__('lang.no_automation_options_selected'));
                            }
                        }
                    },
                ],
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
