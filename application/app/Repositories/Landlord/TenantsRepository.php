<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for templates
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories\Landlord;

use App\Models\Landlord\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Log;

class TenantsRepository {

    /**
     * The leads repository instance.
     */
    protected $tenant;

    /**
     * Inject dependecies
     */
    public function __construct(Tenant $tenant) {
        $this->tenant = $tenant;
    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @return object tenants collection
     */
    public function search($id = '') {

        $tenants = $this->tenant->newQuery();

        // all client fields
        $tenants->selectRaw('*');


        //joins
        $tenants->leftJoin('subscriptions', function($join) {
            $join->on('subscriptions.subscription_customerid', '=', 'tenants.tenant_id')
                 ->whereNotIn('subscriptions.subscription_status', ['cancelled'])
                 ->limit(1);
        });
        $tenants->leftJoin('packages', 'packages.package_id', '=', 'subscriptions.subscription_package_id');

        //default where
        $tenants->whereRaw("1 = 1");

        //filters: id
        if (request()->filled('filter_tenant_id')) {
            $tenants->where('tenant_id', request('filter_tenant_id'));
        }
        if (is_numeric($id)) {
            $tenants->where('tenant_id', $id);
        }

        //filter: activity status
        if (request()->filled('filter_tenant_activity_status')) {
            $tenants->where('tenant_activity_status', request('filter_tenant_activity_status'));
        }

        //filter: country
        if (request()->filled('filter_tenant_country')) {
            $tenants->where('tenant_country', request('filter_tenant_country'));
        }

        //filter: plan
        if (request()->filled('filter_tenant_plan')) {
            $tenants->where('subscriptions.subscription_package_id', request('filter_tenant_plan'));
        }

        //filter: subscription type
        if (request()->filled('filter_tenant_subscription_type')) {
            $tenants->where('subscriptions.subscription_type', request('filter_tenant_subscription_type'));
        }

        //filter: account status
        if (request()->filled('filter_tenant_status')) {
            $tenants->where('tenants.tenant_status', request('filter_tenant_status'));
        }

        //filter: free trial (yes = tenant_status is 'free-trial', no = is not)
        if (request()->filled('filter_tenant_free_trial')) {
            if (request('filter_tenant_free_trial') == 'yes') {
                $tenants->where('tenants.tenant_status', 'free-trial');
            } else {
                $tenants->where('tenants.tenant_status', '!=', 'free-trial');
            }
        }

        //filter: signup period (date presets on tenant_created)
        if (request()->filled('filter_tenant_signup_period')) {
            switch (request('filter_tenant_signup_period')) {
            case 'today':
                $tenants->whereDate('tenants.tenant_created', \Carbon\Carbon::today());
                break;
            case 'yesterday':
                $tenants->whereDate('tenants.tenant_created', \Carbon\Carbon::yesterday());
                break;
            case 'this_week':
                $tenants->whereBetween('tenants.tenant_created', [
                    \Carbon\Carbon::now()->startOfWeek(),
                    \Carbon\Carbon::now()->endOfWeek(),
                ]);
                break;
            case 'last_week':
                $tenants->whereBetween('tenants.tenant_created', [
                    \Carbon\Carbon::now()->subWeek()->startOfWeek(),
                    \Carbon\Carbon::now()->subWeek()->endOfWeek(),
                ]);
                break;
            case 'this_month':
                $tenants->whereMonth('tenants.tenant_created', \Carbon\Carbon::now()->month)
                        ->whereYear('tenants.tenant_created', \Carbon\Carbon::now()->year);
                break;
            case 'last_month':
                $tenants->whereMonth('tenants.tenant_created', \Carbon\Carbon::now()->subMonth()->month)
                        ->whereYear('tenants.tenant_created', \Carbon\Carbon::now()->subMonth()->year);
                break;
            case 'this_year':
                $tenants->whereYear('tenants.tenant_created', \Carbon\Carbon::now()->year);
                break;
            case 'last_year':
                $tenants->whereYear('tenants.tenant_created', \Carbon\Carbon::now()->subYear()->year);
                break;
            }
        }

        //filter: signup date (from)
        if (request()->filled('filter_tenant_signup_date_start')) {
            $tenants->whereDate('tenants.tenant_created', '>=', request('filter_tenant_signup_date_start'));
        }

        //filter: signup date (to)
        if (request()->filled('filter_tenant_signup_date_end')) {
            $tenants->whereDate('tenants.tenant_created', '<=', request('filter_tenant_signup_date_end'));
        }

        //filters: platform usage counts (yes = count > 0, no = count = 0)
        if (request()->filled('filter_tenant_usage_count_team')) {
            $tenants->where('tenant_usage_count_team', request('filter_tenant_usage_count_team') == 'yes' ? '>' : '=', 0);
        }
        if (request()->filled('filter_tenant_usage_count_clients')) {
            $tenants->where('tenant_usage_count_clients', request('filter_tenant_usage_count_clients') == 'yes' ? '>' : '=', 0);
        }
        if (request()->filled('filter_tenant_usage_count_projects')) {
            $tenants->where('tenant_usage_count_projects', request('filter_tenant_usage_count_projects') == 'yes' ? '>' : '=', 0);
        }
        if (request()->filled('filter_tenant_usage_count_tasks')) {
            $tenants->where('tenant_usage_count_tasks', request('filter_tenant_usage_count_tasks') == 'yes' ? '>' : '=', 0);
        }
        if (request()->filled('filter_tenant_usage_count_leads')) {
            $tenants->where('tenant_usage_count_leads', request('filter_tenant_usage_count_leads') == 'yes' ? '>' : '=', 0);
        }
        if (request()->filled('filter_tenant_usage_count_invoices')) {
            $tenants->where('tenant_usage_count_invoices', request('filter_tenant_usage_count_invoices') == 'yes' ? '>' : '=', 0);
        }
        if (request()->filled('filter_tenant_usage_count_estimates')) {
            $tenants->where('tenant_usage_count_estimates', request('filter_tenant_usage_count_estimates') == 'yes' ? '>' : '=', 0);
        }
        if (request()->filled('filter_tenant_usage_count_proposals')) {
            $tenants->where('tenant_usage_count_proposals', request('filter_tenant_usage_count_proposals') == 'yes' ? '>' : '=', 0);
        }
        if (request()->filled('filter_tenant_usage_count_contracts')) {
            $tenants->where('tenant_usage_count_contracts', request('filter_tenant_usage_count_contracts') == 'yes' ? '>' : '=', 0);
        }
        if (request()->filled('filter_tenant_usage_count_tickets')) {
            $tenants->where('tenant_usage_count_tickets', request('filter_tenant_usage_count_tickets') == 'yes' ? '>' : '=', 0);
        }
        if (request()->filled('filter_tenant_usage_count_emails_queued')) {
            $tenants->where('tenant_usage_count_emails_queued', request('filter_tenant_usage_count_emails_queued') == 'yes' ? '>' : '=', 0);
        }
        if (request()->filled('filter_tenant_usage_count_emails_sent')) {
            $tenants->where('tenant_usage_count_emails_sent', request('filter_tenant_usage_count_emails_sent') == 'yes' ? '>' : '=', 0);
        }
        if (request()->filled('filter_tenant_usage_count_emails_processing')) {
            $tenants->where('tenant_usage_count_emails_processing', request('filter_tenant_usage_count_emails_processing') == 'yes' ? '>' : '=', 0);
        }

        //filters: platform usage values (yes = value > 0, no = value = 0)
        if (request()->filled('filter_tenant_usage_value_invoices')) {
            $tenants->where('tenant_usage_value_invoices', request('filter_tenant_usage_value_invoices') == 'yes' ? '>' : '=', 0);
        }
        if (request()->filled('filter_tenant_usage_value_estimates')) {
            $tenants->where('tenant_usage_value_estimates', request('filter_tenant_usage_value_estimates') == 'yes' ? '>' : '=', 0);
        }
        if (request()->filled('filter_tenant_usage_value_leads_converted')) {
            $tenants->where('tenant_usage_value_leads_converted', request('filter_tenant_usage_value_leads_converted') == 'yes' ? '>' : '=', 0);
        }
        if (request()->filled('filter_tenant_usage_value_payments')) {
            $tenants->where('tenant_usage_value_payments', request('filter_tenant_usage_value_payments') == 'yes' ? '>' : '=', 0);
        }
        if (request()->filled('filter_tenant_usage_value_proposals')) {
            $tenants->where('tenant_usage_value_proposals', request('filter_tenant_usage_value_proposals') == 'yes' ? '>' : '=', 0);
        }
        if (request()->filled('filter_tenant_usage_value_contracts')) {
            $tenants->where('tenant_usage_value_contracts', request('filter_tenant_usage_value_contracts') == 'yes' ? '>' : '=', 0);
        }

        //search: various client columns and relationships (where first, then wherehas)
        if (request()->filled('search_query') || request()->filled('query')) {
            $tenants->where(function ($query) {
                $query->orWhere('tenant_status', '=', request('search_query'));
                $query->orWhere('tenant_email', '=', request('search_query'));
                $query->orWhere('subdomain', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('package_name', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('tenant_name', 'LIKE', '%' . request('search_query') . '%');
                //platform usage columns (exact match on count/value)
                $query->orWhere('tenant_usage_count_team', '=', request('search_query'));
                $query->orWhere('tenant_usage_count_clients', '=', request('search_query'));
                $query->orWhere('tenant_usage_count_projects', '=', request('search_query'));
                $query->orWhere('tenant_usage_count_tasks', '=', request('search_query'));
                $query->orWhere('tenant_usage_count_leads', '=', request('search_query'));
                $query->orWhere('tenant_usage_count_invoices', '=', request('search_query'));
                $query->orWhere('tenant_usage_count_estimates', '=', request('search_query'));
                $query->orWhere('tenant_usage_count_proposals', '=', request('search_query'));
                $query->orWhere('tenant_usage_count_contracts', '=', request('search_query'));
                $query->orWhere('tenant_usage_count_tickets', '=', request('search_query'));
                $query->orWhere('tenant_usage_count_emails_queued', '=', request('search_query'));
                $query->orWhere('tenant_usage_count_emails_sent', '=', request('search_query'));
                $query->orWhere('tenant_usage_count_emails_processing', '=', request('search_query'));
                $query->orWhere('tenant_usage_value_invoices', '=', request('search_query'));
                $query->orWhere('tenant_usage_value_estimates', '=', request('search_query'));
                $query->orWhere('tenant_usage_value_leads_converted', '=', request('search_query'));
                $query->orWhere('tenant_usage_value_payments', '=', request('search_query'));
                $query->orWhere('tenant_usage_value_proposals', '=', request('search_query'));
                $query->orWhere('tenant_usage_value_contracts', '=', request('search_query'));
            });
        }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column name
            if (Schema::hasColumn('tenants', request('orderby'))) {
                $tenants->orderBy(request('orderby'), request('sortorder'));
            }
            //others
            switch (request('orderby')) {
            case 'package_name':
                $tenants->orderBy('package_name', request('sortorder'));
                break;
            case 'tenant_tracking_activity_last_seen':
                $tenants->orderBy('tenant_tracking_activity_last_seen', request('sortorder'));
                break;
            case 'tenant_activity_status':
                $tenants->orderBy('tenant_activity_status', request('sortorder'));
                break;
            case 'tenant_package_type':
                $tenants->orderBy('subscription_type', request('sortorder'));
                break;
            }
        } else {
            //default sorting
            $tenants->orderBy('tenant_id', 'asc');
        }

        // Get the results and return them.
        return $tenants->paginate(config('system.settings_system_pagination_limits'));
    }

    /**
     * Create a new record
     * @return mixed int|bool
     */
    public function create() {

        //save new user
        $tenant = new $this->tenants;

        //data
        $tenant->tenant_categoryid = request('tenant_categoryid');
        $tenant->tenant_creatorid = auth()->id();

        //save and return id
        if ($tenant->save()) {
            return $tenant->tenant_id;
        } else {
            Log::error("unable to create record - database error", ['process' => '[ItemRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * update a record
     * @param int $id record id
     * @return mixed int|bool
     */
    public function update($id) {

        //get the record
        if (!$tenant = $this->tenants->find($id)) {
            return false;
        }

        //general
        $tenant->tenant_categoryid = request('tenant_categoryid');

        //save
        if ($tenant->save()) {
            return $tenant->tenant_id;
        } else {
            Log::error("unable to update record - database error", ['process' => '[ItemRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

    }

    /**
     * various feeds for ajax auto complete
     * @param string $type (company_name)
     * @param string $searchterm
     * @return object tenant model object
     */
    public function autocompleteFeed( $searchterm = '') {

        //validation
        if ($searchterm == '') {
            return [];
        }

        //start
        $query = $this->tenant->newQuery();

        $query->selectRaw('tenant_name AS value, tenant_id AS id');
        $query->where('tenant_name', 'LIKE', '%' . $searchterm . '%');

        //return
        return $query->get();
    }

}