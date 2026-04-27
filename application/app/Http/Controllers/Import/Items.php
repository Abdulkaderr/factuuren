<?php

/** --------------------------------------------------------------------------------
 * This controller manages all the business logic for importing items from Excel files
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Http\Responses\Import\Items\CreateResponse;
use App\Http\Responses\Import\Common\StoreResponse;
use App\Imports\ItemsImport;
use App\Repositories\ImportExportRepository;
use App\Repositories\SystemRepository;
use Illuminate\Validation\Rule;
use Validator;

class Items extends Controller {

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
        $this->middleware('importItemsMiddlewareCreate')->only([
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
            'type' => 'items',
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

        //fire storing event
        event(new \App\Events\Import\Items\ItemImportStoring(request()));

        //import items
        $import = new ItemsImport();
        $import->import($file_path);

        //log erors
        $importexportrepo->logImportError($import->failures(), $import_ref);

        //reponse payload
        $payload = [
            'type' => 'items',
            'error_count' => count($import->failures()),
            'error_ref' => $import_ref,
            'count_passed' => $import->getRowCount(),
            'skipped' => $import->getSkippedCount(),
        ];

        //fire stored event
        event(new \App\Events\Import\Items\ItemImportStored(request(), $import_ref, $payload));

        //process reponse
        return new StoreResponse($payload);

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
