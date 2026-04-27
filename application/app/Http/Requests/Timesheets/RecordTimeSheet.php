<?php

/** --------------------------------------------------------------------------------
 * This middleware class validates input requests for the timesheet controller
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Requests\Timesheets;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecordTimeSheet extends FormRequest {

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
            'my_assigned_tasks.*.required' => __('lang.task') . ' - ' . __('lang.is_required'),
            'my_assigned_tasks.*.exists' => __('lang.task') . ' - ' . __('lang.is_invalid'),
            'timer_created.*.required' => __('lang.date') . ' - ' . __('lang.is_required'),
            'timer_created.*.date' => __('lang.date') . ' - ' . __('lang.is_invalid'),
            'manual_time_hours.*.required' => __('lang.hours') . ' - ' . __('lang.is_required'),
            'manual_time_hours.*.numeric' => __('lang.hours') . ' - ' . __('lang.must_be_numeric'),
            'manual_time_minutes.*.required' => __('lang.minutes') . ' - ' . __('lang.is_required'),
            'manual_time_minutes.*.numeric' => __('lang.minutes') . ' - ' . __('lang.must_be_numeric'),
        ];
    }

    /**
     * Validate the request
     * @return array
     */
    public function rules() {

        $rules = [];

        // Check if arrays exist
        if (is_array(request('my_assigned_tasks'))) {
            foreach (request('my_assigned_tasks') as $key => $value) {
                $rules["my_assigned_tasks.{$key}"] = [
                    'required',
                    Rule::exists('tasks', 'task_id'),
                ];
                $rules["timer_created.{$key}"] = [
                    'required',
                    'date',
                ];
                $rules["manual_time_hours.{$key}"] = [
                    'required',
                    'numeric',
                ];
                $rules["manual_time_minutes.{$key}"] = [
                    'required',
                    'numeric',
                ];
            }
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
