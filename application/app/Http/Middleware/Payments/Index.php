<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [index] precheck processes for payments
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Payments;

use App\Models\Payment;
use Closure;
use Log;

class Index {

    /**
     * This middleware does the following
     *   2. checks users permissions to [view] payments
     *   3. modifies the request object as needed
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //validate module status
        if (!config('visibility.modules.payments')) {
            abort(404, __('lang.the_requested_service_not_found'));
            return $next($request);
        }

        //various frontend and visibility settings
        $this->fronteEnd();

        //set for dynamically loading the payment modal
        $this->dynamicLoad();

        //handle clear filter request
        if (request()->filled('clear-filter') && request('clear-filter') == 'yes') {
            $query = $this->clearFilter();
            return redirect('/payments' . $query);
        }

        //filter handling
        if (request()->routeIs('payments.search')) {
            if (request('query-type') == 'filter') {
                $this->saveFilter();
            } else {
                $this->applyFilter();
            }
        } else {
            $this->applyFilter();
        }

        //embedded request: limit by supplied resource data
        if (request()->filled('paymentresource_type') && request()->filled('paymentresource_id')) {
            //project payments
            if (request('paymentresource_type') == 'project') {
                request()->merge([
                    'filter_payment_projectid' => request('paymentresource_id'),
                ]);
            }
            //client payments
            if (request('paymentresource_type') == 'client') {
                request()->merge([
                    'filter_payment_clientid' => request('paymentresource_id'),
                ]);
            }
            //invoice payments
            if (request('paymentresource_type') == 'invoice') {
                request()->merge([
                    'filter_payment_invoiceid' => request('paymentresource_id'),
                ]);
            }

        }

        //client user permission
        if (auth()->user()->is_client) {
            if (auth()->user()->is_client_owner) {
                //sanity client
                request()->merge([
                    'filter_payment_clientid' => auth()->user()->clientid,
                ]);
                return $next($request);
            }
        }

        //admin user permission
        if (auth()->user()->is_team) {
            if (auth()->user()->role->role_payments >= 1) {
                return $next($request);
            }
        }

        //permission denied
        Log::error("permission denied", ['process' => '[permissions][payments][index]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }

    /*
     * various frontend and visibility settings
     */
    private function fronteEnd() {

        /**
         * shorten resource type and id (for easy appending in blade templates)
         * [usage]
         *   replace the usual url('payment') with urlResource('payment'), in blade templated
         * */
        if (request('paymentresource_type') != '' || is_numeric(request('paymentresource_id'))) {
            request()->merge([
                'resource_query' => 'ref=list&paymentresource_type=' . request('paymentresource_type') . '&paymentresource_id=' . request('paymentresource_id'),
            ]);
        } else {
            request()->merge([
                'resource_query' => 'ref=list',
            ]);
        }

        //default show some table columns
        config([
            'visibility.payments_col_client' => true,
            'visibility.payments_col_project' => true,
            'visibility.filter_panel_client_project' => true,
            'visibility.payments_col_method' => true,
            'visibility.payments_col_id' => true,
            'visibility.payments_col_invoiceid' => true,
            'visibility.payments_col_status' => true,
            'visibility.payments_col_refund' => true,
            'visibility.payments_col_tags' => true,
        ]);

        //permissions -viewing
        if (auth()->user()->role->role_payments >= 1) {
            if (auth()->user()->is_team) {
                config([
                    //visibility
                    'visibility.list_page_actions_filter_button' => true,
                    'visibility.list_page_actions_search' => true,
                    'visibility.stats_toggle_button' => true,
                    'visibility.payments_col_action' => true,
                ]);
            }
            if (auth()->user()->is_client) {
                config([
                    //visibility
                    'visibility.list_page_actions_search' => true,
                    'visibility.payments_col_client' => false,
                    'visibility.payments_col_method' => false,
                ]);
            }
        }

        //permissions -adding
        if (auth()->user()->role->role_payments >= 2) {
            config([
                //visibility
                'visibility.list_page_actions_add_button' => true,
                'visibility.action_buttons_edit' => true,
                'visibility.payments_col_checkboxes' => true,
            ]);
        }

        //permissions -deleting
        if (auth()->user()->role->role_payments >= 3) {
            config([
                //visibility
                'visibility.action_buttons_delete' => true,
            ]);
        }

        //columns visibility
        if (request('paymentresource_type') == 'project') {
            config([
                //visibility
                'visibility.payments_col_client' => false,
                'visibility.payments_col_project' => false,
                'visibility.filter_panel_client_project' => false,
            ]);
        }

        //columns visibility
        if (request('paymentresource_type') == 'client') {
            config([
                //visibility
                'visibility.payments_col_client' => false,
                'visibility.filter_panel_client_project' => false,
                'visibility.payments_col_method' => false,
                'visibility.filter_panel_clients_projects' => true,
            ]);
        }

        //column visibility
        if (request('paymentresource_type') == 'invoice') {
            config([
                //visibility
                'visibility.payments_col_id' => false,
                'visibility.payments_col_client' => false,
                'visibility.filter_panel_client_project' => false,
                'visibility.payments_col_action' => false,
                'visibility.payments_col_invoiceid' => false,
                'visibility.payments_col_checkboxes' => false,
                'visibility.payments_col_project' => false,
            ]);
        }

        //importing and exporting
        config([
            'visibility.list_page_actions_exporting' => (auth()->user()->role->role_content_export == 'yes') ? true : false,
        ]);

    }

    /*
     * set the front end to load the modal dynamically
     */
    private function dynamicLoad() {
        //validate that the url is for loading a payment dynmically
        if (is_numeric(request()->route('payment')) && request()->segment(2) == 'v') {
            config([
                'visibility.dynamic_load_modal' => true,
                'settings.dynamic_trigger_dom' => '#dynamic-payment-content',
            ]);
        }
    }

    /*
     * save filter data when user submits filter panel
     */
    private function saveFilter() {

        //get or create filter record for current user
        if (!$filter = \App\Models\Filter::where('filter_userid', auth()->id())
            ->where('filter_type', 'payment')->first()) {
            $filter = new \App\Models\Filter();
            $filter->filter_userid = auth()->id();
            $filter->filter_type = 'payment';
            $filter->filter_created = now();
        }

        //check if remember filter checkbox is enabled
        if (request()->filled('filter_remember')) {
            //get all GET parameters
            $payload = request()->all();

            //exclude system parameters that shouldn't be saved
            $exclude = ['query-type', 'action', 'source', 'filter_remember'];
            $payload = array_diff_key($payload, array_flip($exclude));

            //handle select2 ajax fields - store as structured array with id and text
            if (isset($payload['filter_payment_clientid']) && !empty($payload['filter_payment_clientid'])) {
                if ($client = \App\Models\Client::where('client_id', $payload['filter_payment_clientid'])->first()) {
                    $payload['filter_payment_clientid'] = [
                        'id' => $payload['filter_payment_clientid'],
                        'text' => $client->client_company_name,
                    ];
                }
            }

            //handle dynamic project field - store as structured array with id and text
            if (isset($payload['filter_payment_projectid']) && !empty($payload['filter_payment_projectid'])) {
                if ($project = \App\Models\Project::where('project_id', $payload['filter_payment_projectid'])->first()) {
                    $payload['filter_payment_projectid'] = [
                        'id' => $payload['filter_payment_projectid'],
                        'text' => $project->project_title,
                    ];
                }
            }

            //save payload - mutator automatically handles JSON encoding
            $filter->filter_payload = $payload;
            $filter->filter_filter_applied = 'yes';
            $filter->filter_remember = 'yes';
            $filter->filter_updated = now();
            $filter->save();

            //set config for active filter
            config(['filter.status' => 'active']);
            config(['filter.saved_data' => $payload]);

        } else {
            //clear filter data
            $filter->filter_payload = null;
            $filter->filter_filter_applied = 'no';
            $filter->filter_remember = 'no';
            $filter->filter_updated = now();
            $filter->save();

            //set config for no active filter
            config(['filter.status' => '']);
            config(['filter.saved_data' => []]);
        }
    }

    /*
     * apply saved filter data to current request when page loads
     */
    private function applyFilter() {

        //get filter record for current user
        if ($filter = \App\Models\Filter::where('filter_userid', auth()->id())
            ->where('filter_type', 'payment')
            ->where('filter_filter_applied', 'yes')
            ->first()) {

            //accessor automatically handles JSON decoding
            $payload = $filter->filter_payload;

            if (is_array($payload) && count($payload) > 0) {
                //prepare data for request merge - extract IDs from array values
                $request_data = [];
                foreach ($payload as $key => $value) {
                    //if value is an array with 'id' and 'text', extract just the ID for request
                    if (is_array($value) && isset($value['id']) && isset($value['text'])) {
                        $request_data[$key] = $value['id'];
                    } else {
                        $request_data[$key] = $value;
                    }
                }

                //merge into current request
                request()->merge($request_data);

                //set config for active filter (keep full payload with arrays)
                config(['filter.status' => 'active']);
                config(['filter.saved_data' => $payload]);

                return;
            }
        }

        //no active filter
        config(['filter.status' => '']);
        config(['filter.saved_data' => []]);
    }

    /*
     * clear saved filter from database
     */
    private function clearFilter() {

        //get filter record for current user
        if ($filter = \App\Models\Filter::where('filter_userid', auth()->id())
            ->where('filter_type', 'payment')->first()) {

            $filter->filter_payload = null;
            $filter->filter_filter_applied = 'no';
            $filter->filter_remember = 'no';
            $filter->save();
        }

        //set config for no active filter
        config(['filter.status' => '']);

        //if coming from a stats panel, pass through only the original URL query params (minus clear-filter)
        if (request('source') == 'stats_panels') {
            $params = array_diff_key(request()->query(), ['clear-filter' => '']);
            return count($params) ? '?' . http_build_query($params) : null;
        }

        return null;
    }
}
