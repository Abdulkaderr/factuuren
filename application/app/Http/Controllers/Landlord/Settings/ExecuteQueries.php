<?php

/** --------------------------------------------------------------------------------
 * This controller manages all the business logic for executing SQL queries on tenants
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Controllers\Landlord\Settings;

use App\Http\Controllers\Controller;
use App\Http\Responses\Landlord\Settings\ExecuteQueries\CreateResponse;
use App\Http\Responses\Landlord\Settings\ExecuteQueries\DestroyResponse;
use App\Http\Responses\Landlord\Settings\ExecuteQueries\IndexResponse;
use App\Http\Responses\Landlord\Settings\ExecuteQueries\ShowResponse;
use App\Http\Responses\Landlord\Settings\ExecuteQueries\StoreResponse;
use Validator;

class ExecuteQueries extends Controller {

    public function __construct() {

        parent::__construct();

        $this->middleware('auth');
    }

    /**
     * Display main page with queries table
     * @return blade view
     */
    public function index() {

        // Fetch latest 100 queries
        $queries = \App\Models\Landlord\ExecuteQuery::orderBy('execute_query_created', 'desc')
            ->limit(100)
            ->get();

        // Add counts to each query
        foreach ($queries as $query) {
            $query->passed_count = \App\Models\Landlord\ExecuteQueryLog::where('execute_queries_log_query_uniqueid', $query->execute_query_uniqueid)
                ->where('execute_queries_log_status', 'passed')
                ->count();

            $query->failed_count = \App\Models\Landlord\ExecuteQueryLog::where('execute_queries_log_query_uniqueid', $query->execute_query_uniqueid)
                ->where('execute_queries_log_status', 'failed')
                ->count();

            $query->total_count = $query->passed_count + $query->failed_count;
        }

        $payload = [
            'page' => $this->pageSettings('index'),
            'queries' => $queries,
        ];

        return new IndexResponse($payload);
    }

    /**
     * Show modal form for adding new query
     * @return ajax response
     */
    public function create() {

        $payload = [
            'page' => $this->pageSettings('create'),
        ];

        return new CreateResponse($payload);
    }

    /**
     * Store a newly created query to database
     * @return ajax response
     */
    public function store() {

        // Validation
        $rules = [
            'execute_query_sql' => 'required',
            'execute_query_description' => 'required',
        ];

        $validator = Validator::make(request()->all(), $rules);
        if ($validator->fails()) {
            abort(409, implode('<li>', $validator->errors()->all()));
        }

        // Create query
        $query = new \App\Models\Landlord\ExecuteQuery();
        $query->execute_query_uniqueid = str_unique();
        $query->execute_query_creatorid = auth()->id();
        $query->execute_query_description = request('execute_query_description');
        $query->execute_query_sql = request('execute_query_sql');
        $query->execute_query_status = 'draft';
        $query->save();

        // Fetch for display with counts
        $queries = \App\Models\Landlord\ExecuteQuery::where('execute_query_id', $query->execute_query_id)->get();

        foreach ($queries as $q) {
            $q->passed_count = 0;
            $q->failed_count = 0;
            $q->total_count = 0;
        }

        $payload = [
            'queries' => $queries,
        ];

        return new StoreResponse($payload);
    }

    /**
     * Update query status (activate, pause)
     * @param string $id execute_query_uniqueid
     * @return ajax response
     */
    public function updateStatus($id) {

        // Find query
        if (!$query = \App\Models\Landlord\ExecuteQuery::where('execute_query_uniqueid', $id)->first()) {
            abort(409, __('lang.error_request_could_not_be_completed'));
        }

        // Update status
        $query->execute_query_status = request('status');
        $query->save();

        $payload = [
            'type' => 'update-success',
        ];

        return new StoreResponse($payload);
    }

    /**
     * Delete query and associated logs
     * @param string $id execute_query_uniqueid
     * @return ajax response
     */
    public function destroy($id) {

        // Find query
        if (!$query = \App\Models\Landlord\ExecuteQuery::where('execute_query_uniqueid', $id)->first()) {
            abort(409, __('lang.error_request_could_not_be_completed'));
        }

        // Delete logs
        \App\Models\Landlord\ExecuteQueryLog::where('execute_queries_log_query_uniqueid', $query->execute_query_uniqueid)->delete();

        // Delete query
        $query->delete();

        $payload = [
            'query_id' => $id,
        ];

        return new DestroyResponse($payload);
    }

    /**
     * Display logs for a specific query
     * @param string $id execute_query_uniqueid
     * @return ajax response
     */
    public function showLogs($id) {

        // Find query
        if (!$query = \App\Models\Landlord\ExecuteQuery::where('execute_query_uniqueid', $id)->first()) {
            abort(409, __('lang.error_request_could_not_be_completed'));
        }

        // Build query for logs
        $logs_query = \App\Models\Landlord\ExecuteQueryLog::where('execute_queries_log_query_uniqueid', $id);

        // Apply filter
        $filter = request('filter', 'all');
        if ($filter == 'passed') {
            $logs_query->where('execute_queries_log_status', 'passed');
        } elseif ($filter == 'failed') {
            $logs_query->where('execute_queries_log_status', 'failed');
        }

        $logs = $logs_query->orderBy('execute_queries_log_created', 'desc')->get();

        $payload = [
            'query' => $query,
            'logs' => $logs,
            'filter' => $filter,
        ];

        return new ShowResponse($payload);
    }

    /**
     * Basic page setting for this section of the app
     * @param string $section page section (optional)
     * @return array
     */
    private function pageSettings($section = '') {

        $page = [
            'crumbs' => [
                __('lang.settings'),
                __('lang.execute_sql_queries'),
            ],
            'crumbs_special_class' => 'list-pages-crumbs',
            'meta_title' => __('lang.settings'),
            'heading' => __('lang.settings'),
            'page' => 'landlord-settings',
            'mainmenu_settings' => 'active',
            'inner_group_menu_debugging' => 'active',
            'inner_menu_execute_queries' => 'active',
        ];

        // Show left inner menu
        config(['visibility.left_inner_menu' => 'settings']);

        return $page;
    }
}
