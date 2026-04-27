<?php

/** --------------------------------------------------------------------------------
 * This class validates input requests for the Refunds controller
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Requests\Refunds;

use App\Rules\NoTags;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RefundStoreUpdate extends FormRequest {

    /**
     * Authorization is handled via middleware — always return true here
     */
    public function authorize() {
        return true;
    }

    /**
     * Validation rules
     */
    public function rules() {

        $rules = [];

        /**-------------------------------------------------------
         * [create] only rules (POST)
         * ------------------------------------------------------*/
        if ($this->getMethod() == 'POST') {
            $rules += [
                'refund_paymentid' => [
                    'required',
                    Rule::exists('payments', 'payment_id'),
                ],
            ];
        }

        /**-------------------------------------------------------
         * common rules for both [create] and [update]
         * ------------------------------------------------------*/
        $rules += [
            'refund_date' => [
                'required',
                'date',
            ],
            'refund_notes' => [
                'nullable',
                new NoTags,
            ],
        ];

        return $rules;
    }

    /**
     * Custom validation messages
     */
    public function messages() {
        return [
            'refund_paymentid.exists' => __('lang.payment_not_found'),
        ];
    }

    /**
     * Concatenate all validation errors into an HTML list and abort
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
