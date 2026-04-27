<?php

/** --------------------------------------------------------------------------------
 * This request class validates input for creating tasks from estimate line items
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Requests\Estimates;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreTasksRequest extends FormRequest {

    /**
     * we are checking authorised users via the middleware
     * so just return true here
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Filter out any line items that already have a task mapped to them
     * for this estimate's project, preventing duplicate task creation
     */
    protected function prepareForValidation() {

        if (!is_array(request('selected_lineitems')) || !request()->filled('selected_lineitems')) {
            return;
        }

        $estimate_id = $this->route('estimate');

        if (!$estimate = \App\Models\Estimate::Where('bill_estimateid', $estimate_id)->first()) {
            return;
        }

        if (!is_numeric($estimate->bill_projectid)) {
            return;
        }

        //filter out line items that already have a task in this project
        $filtered = array_values(array_filter(request('selected_lineitems'), function ($lineitem_uniqueid) use ($estimate) {
            return !\App\Models\Task::Where('task_mapping_type', 'lineitem')
                ->Where('task_mapping_uniqueid', $lineitem_uniqueid)
                ->Where('task_projectid', $estimate->bill_projectid)
                ->exists();
        }));

        $this->merge(['selected_lineitems' => $filtered]);
    }

    /**
     * custom error messages for specific validation checks
     * @return array
     */
    public function messages() {
        return [
            'milestone_id.required'       => __('lang.milestone') . ' - ' . __('lang.is_required'),
            'task_status.required'        => __('lang.status') . ' - ' . __('lang.is_required'),
            'selected_lineitems.required' => __('lang.create_tasks_all_converted'),
            'selected_lineitems.min'      => __('lang.create_tasks_all_converted'),
        ];
    }

    /**
     * Validate the request
     * @return array
     */
    public function rules() {
        return [
            'milestone_id'       => ['required'],
            'task_status'        => ['required'],
            'selected_lineitems' => ['required', 'array', 'min:1'],
        ];
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
