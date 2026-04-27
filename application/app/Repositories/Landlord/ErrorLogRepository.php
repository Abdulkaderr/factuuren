<?php

/** --------------------------------------------------------------------------------
 * Repository for fetching error log records from the landlord database.
 * Scoped to a specific tenant and optionally filtered by log type.
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories\Landlord;

use App\Models\Landlord\Log;

class ErrorLogRepository {


        /**
     * The logs repository instance.
     */
    protected $logs;

    /**
     * Inject dependecies
     */
    public function __construct(Log $logs) {
        $this->logs = $logs;
    }


    /**
     * Search and return paginated error log records for a given tenant.
     * Optionally filters by log_resource_type if a log_type is in the request.
     *
     * @param int $tenant_id the tenant whose logs to fetch
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function search($tenant_id) {

        $logs = $this->logs->newQuery();

        //scope to this tenant only
        $logs->where('log_resource_id', $tenant_id);

        //filter by log type (skip when 'all' is passed)
        if (request()->filled('log_type') && request('log_type') !== 'all') {
            $logs->where('log_resource_type', request('log_type'));
        }

        //newest first
        $logs->orderBy('log_id', 'desc');

        return $logs->paginate(25);
    }
}
