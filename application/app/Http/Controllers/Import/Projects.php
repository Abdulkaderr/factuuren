<?php

/** --------------------------------------------------------------------------------
 * This controller manages the import functionality for projects
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Http\Responses\Import\Projects\CreateResponse;
use App\Http\Responses\Import\Common\StoreResponse;
use App\Imports\ProjectsImport;
use App\Repositories\ImportExportRepository;
use App\Repositories\SystemRepository;
use Illuminate\Validation\Rule;
use Validator;

class Projects extends Controller {

    /**
     * The event repository instance.
     */
    protected $eventrepo;

    public function __construct() {

        //parent
        parent::__construct();

        //authenticated
        $this->middleware('auth');

        //Permissions on methods
        $this->middleware('importProjectsMiddlewareCreate')->only([
            'create',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create(SystemRepository $systemrepo) {

        //check server requirements for excel module
        $server_check = $systemrepo->serverRequirementsExcel();

        //reponse payload
        $payload = [
            'type' => 'projects',
            'requirements' => $server_check['requirements'],
            'server_status' => $server_check['status'],
            'page' => $this->pageSettings('create'),
        ];

        //show the form
        return new CreateResponse($payload);
    }

    /**
     * Store a newly created resource in storage.
     * @return \Illuminate\Http\Response
     */
    public function store(ImportExportRepository $importexportrepo) {

        //unique transaction ref
        $import_ref = str_unique();

        //error count default
        $error_count = 0;

        //imported
        $imported = false;

        //uploaded file path
        $file_path = BASE_DIR . "/storage/temp/" . request('importing-file-uniqueid') . "/" . request('importing-file-name');

        //initial validation
        if (!$importexportrepo->validateImport()) {
            abort(409, __('lang.error_request_could_not_be_completed'));
        }

        //unique import ID (transaction tracking)
        request()->merge([
            'import_ref' => $import_ref,
        ]);

        //import projects
        $import = new ProjectsImport();
        $import->import($file_path);

        //log erors
        $importexportrepo->logImportError($import->failures(), $import_ref);

        //get actual count of saved projects from database
        $count_passed = \App\Models\Project::where('project_importid', $import_ref)->count();

        //additional processing
        if ($count_passed > 0) {
            $this->processCollection($import);
        }

        //reponse payload
        $payload = [
            'type' => 'projects',
            'error_count' => count($import->failures()),
            'error_ref' => $import_ref,
            'count_passed' => $count_passed,
            'skipped' => 0,
        ];

        //process reponse
        return new StoreResponse($payload);

    }

    /**
     * additional processing for the imported collection
     */
    private function processCollection($import) {

        //get assigned users data from import
        $assignedUsersData = $import->getAssignedUsers();

        //process each project's assigned users
        foreach ($assignedUsersData as $project_uniqueid => $assigned_users_string) {

            //find the project by unique ID
            $project = \App\Models\Project::where('project_uniqueid', $project_uniqueid)->first();

            if (!$project) {
                continue;
            }

            //parse assigned users
            $names = explode(',', $assigned_users_string);

            foreach ($names as $name) {
                $name = trim($name);
                if (empty($name)) {
                    continue;
                }

                // Find team member by full name (case-insensitive)
                $user = \App\Models\User::where('type', 'team')
                    ->whereRaw("LOWER(CONCAT(first_name, ' ', last_name)) = ?", [strtolower($name)])
                    ->first();

                if ($user) {
                    $assigned = new \App\Models\ProjectAssigned();
                    $assigned->projectsassigned_projectid = $project->project_id;
                    $assigned->projectsassigned_userid = $user->id;
                    $assigned->save();
                }
            }
        }
    }

    /**
     * basic page setting for this section of the app
     * @param string $section page section (optional)
     * @param array $data any other data (optional)
     * @return array
     */
    private function pageSettings($section = '', $data = []) {

        //common settings
        $page = [

        ];

        //return
        return $page;
    }
}
