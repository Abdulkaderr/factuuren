<?php

/** --------------------------------------------------------------------------------
 * This middleware checks if the user has permission to create tasks on the
 * project attached to the estimate
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Estimates;

use App\Permissions\ProjectPermissions;
use Closure;
use Log;

class StoreTasks {

    /**
     * The permission repository instance.
     */
    protected $projectpermissions;

    /**
     * Inject any dependencies here
     */
    public function __construct(ProjectPermissions $projectpermissions) {
        $this->projectpermissions = $projectpermissions;
    }

    /**
     * This middleware does the following:
     *   1. checks users permissions to create tasks on the estimate's project
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //get the estimate
        $estimate_id = $request->route('estimate');
        if (!$estimate = \App\Models\Estimate::Where('bill_estimateid', $estimate_id)->first()) {
            abort(409, __('lang.error_request_could_not_be_completed'));
        }

        //check user has permission to create tasks on the attached project
        if (is_numeric($estimate->bill_projectid)) {
            if ($project = \App\Models\Project::Where('project_id', $estimate->bill_projectid)->first()) {
                if ($this->projectpermissions->check('tasks-add', $project)) {
                    return $next($request);
                }
            }
        }

        //permission denied
        Log::error("permission denied", ['process' => '[permissions][estimates][store-tasks]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }
}
