<?php

/** --------------------------------------------------------------------------------
 * This controller manages all the business logic for contract contracts
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contracts\ContractUpdateAutomation;
use App\Http\Requests\Contracts\StoreUpdate;
use App\Http\Responses\Common\ChangeCategoryResponse;
use App\Http\Responses\Contracts\AttachProjectResponse;
use App\Http\Responses\Contracts\ChangeCategoryUpdateResponse;
use App\Http\Responses\Contracts\ChangeStatusResponse;
use App\Http\Responses\Contracts\CreateCloneResponse;
use App\Http\Responses\Contracts\CreateResponse;
use App\Http\Responses\Contracts\DestroyResponse;
use App\Http\Responses\Contracts\EditAutomationResponse;
use App\Http\Responses\Contracts\EmailResponse;
use App\Http\Responses\Contracts\IndexResponse;
use App\Http\Responses\Contracts\PinningResponse;
use App\Http\Responses\Contracts\PublishResponse;
use App\Http\Responses\Contracts\PublishScheduledResponse;
use App\Http\Responses\Contracts\SignatureResponse;
use App\Http\Responses\Contracts\StoreResponse;
use App\Http\Responses\Contracts\UpdateAutomationResponse;
use App\Http\Responses\Documents\ShowEditResponse;
use App\Http\Responses\Documents\ShowPreviewResponse;
use App\Models\Category;
use App\Models\Contract;
use App\Http\Responses\Contracts\EditTagsResponse;
use App\Repositories\CategoryRepository;
use App\Repositories\CloneContractRepository;
use App\Repositories\ContractAutomationRepository;
use App\Repositories\ContractRepository;
use App\Repositories\EmailerRepository;
use App\Repositories\EstimateGeneratorRepository;
use App\Repositories\EstimateRepository;
use App\Repositories\EventRepository;
use App\Repositories\EventTrackingRepository;
use App\Repositories\PinnedRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;
use Intervention\Image\Exception\NotReadableException;
use Validator;

class Contracts extends Controller {

    /**
     * The repository instances.
     */
    protected $contractrepo;
    protected $userrepo;
    protected $estimaterepo;
    protected $eventrepo;
    protected $trackingrepo;
    protected $emailerrepo;
    protected $tagrepo;

    public function __construct(
        ContractRepository $contractrepo,
        UserRepository $userrepo,
        EstimateRepository $estimaterepo,
        EventRepository $eventrepo,
        EventTrackingRepository $trackingrepo,
        EmailerRepository $emailerrepo,
        TagRepository $tagrepo
    ) {

        //parent
        parent::__construct();

        $this->tagrepo = $tagrepo;

        //authenticated
        $this->middleware('auth')->except([
            'showPublic',
            'sign',
            'signGuest',
            'signGuestAction',
        ]);

        //Filtering
        $this->middleware('contractsMiddlewareFiltering')->only([
            'index',
        ]);

        $this->middleware('contractsMiddlewareIndex')->only([
            'index',
            'update',
            'store',
            'changeCategoryUpdate',
            'changeStatus',
            'updateAutomation',
            'updateTags',
        ]);

        $this->middleware('contractsMiddlewareEdit')->only([
            'editingContract',
            'update',
            'resendEmail',
            'publish',
            'changeStatus',
            'editAutomation',
            'editTags',
            'updateTags',
        ]);

        $this->middleware('contractsMiddlewareCreate')->only([
            'create',
            'store',
        ]);

        $this->middleware('contractsMiddlewareShow')->only([
            'show',
        ]);

        $this->middleware('contractsMiddlewareDestroy')->only([
            'destroy',
        ]);

        //only needed for the [action] methods
        $this->middleware('contractsMiddlewareBulkEdit')->only([
            'changeCategoryUpdate',
        ]);

        $this->middleware('contractsMiddlewareShowPublic')->only([
            'showPublic',
            'sign',
        ]);

        $this->middleware('contractsMiddlewareSignClient')->only([
            'signClient',
            'signClientAction',
        ]);

        $this->middleware('contractsMiddlewareSignTeam')->only([
            'signTeam',
            'signTeamAction',
        ]);

        //repos
        $this->contractrepo = $contractrepo;
        $this->userrepo = $userrepo;
        $this->estimaterepo = $estimaterepo;
        $this->eventrepo = $eventrepo;
        $this->trackingrepo = $trackingrepo;
        $this->emailerrepo = $emailerrepo;
    }

    /**
     * Display a listing of contracts
     * @param object CategoryRepository instance of the repository
     * @param object Category instance of the repository
     * @return blade view | ajax view
     */
    public function index(CategoryRepository $categoryrepo, Category $categorymodel) {

        //get contracts
        $contracts = $this->contractrepo->search();

        //get all categories (type: contract) - for filter panel
        $categories = $categoryrepo->get('contract');

        //get all tags (type: contract) - for filter panel
        $tags = $this->tagrepo->getByType('contract');

        //reponse payload
        $payload = [
            'page' => $this->pageSettings('contracts'),
            'contracts' => $contracts,
            'count' => $contracts->count(),
            'stats' => $this->statsWidget(),
            'categories' => $categories,
            'tags' => $tags,
        ];

        //show the view
        return new IndexResponse($payload);
    }

    /**
     * Show the form for creating a new contract
     * @param object CategoryRepository instance of the repository
     * @return \Illuminate\Http\Response
     */
    public function create(CategoryRepository $categoryrepo) {

        //client categories
        $categories = $categoryrepo->get('contract');

        //templates
        $templates = \App\Models\ContractTemplate::orderBy('contract_template_id', 'ASC')->get();

        //we are on client page
        if (config('modal.type') == 'preset-client') {
            //get projects
            $projects = \App\Models\Project::Where('project_clientid', request('contractresource_id'))
                ->orderBy('project_title', 'asc')
                ->get();
            //save to config
            config([
                'client.id' => request('contractresource_id'),
                'client.projects' => $projects,
            ]);
        }

        //tags
        $tags = $this->tagrepo->getByType('contract');

        //reponse payload
        $payload = [
            'page' => $this->pageSettings('create'),
            'categories' => $categories,
            'templates' => $templates,
            'tags' => $tags,
        ];

        //show the form
        return new CreateResponse($payload);
    }

    /**
     * Store a newly created contractin storage.
     * @param object StoreUpdate instance of the repository
     * @param object UnitRepository instance of the repository
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdate $request) {

        //get client
        if (!$client = \App\Models\Client::Where('client_id', request('doc_client_id'))->first()) {
            abort(409, __('lang.client_not_found'));
        }
        //set the fall back details
        $user = $this->userrepo->getClientAccountOwner(request('doc_client_id'));
        $doc_fallback_client_first_name = $user->first_name;
        $doc_fallback_client_last_name = $user->last_name;
        $doc_fallback_client_email = $user->email;

        //fire storing event
        event(new \App\Events\Contracts\ContractStoring(request()));

        //create the contract
        $contract = new \App\Models\Contract();
        $contract->doc_unique_id = str_unique();
        $contract->doc_creatorid = auth()->id();
        $contract->doc_type = 'contract';
        $contract->doc_categoryid = request('doc_categoryid');
        $contract->doc_client_id = request('doc_client_id');
        $contract->doc_lead_id = request('doc_lead_id');
        $contract->docresource_type = 'client';
        $contract->docresource_id = request('doc_client_id');
        $contract->doc_heading = __('lang.contract');
        $contract->doc_heading_color = '#FFFFFF';
        $contract->doc_title_color = '#FFFFFF';
        $contract->doc_title = request('doc_title');
        $contract->doc_date_start = request('doc_date_start');
        $contract->doc_date_end = request('doc_date_end');
        $contract->doc_value = request('doc_value');
        $contract->doc_fallback_client_first_name = $doc_fallback_client_first_name;
        $contract->doc_fallback_client_last_name = $doc_fallback_client_last_name;
        $contract->doc_fallback_client_email = $doc_fallback_client_email;

        //automation
        $settings = \App\Models\Settings2::find(1);
        $contract->contract_automation_status = (request('contract_automation_status') == 'on') ? 'enabled' : 'disabled';

        if ($contract->contract_automation_status == 'enabled') {

            //fetch the client invoice due days
            $invoice_due_days = $client->client_billing_invoice_due_days ?? config('system.settings2_contracts_automation_invoice_due_date', 7);

            //save automation
            $contract->contract_automation_create_project = $settings->settings2_contracts_automation_create_project;
            $contract->contract_automation_project_title = $contract->doc_title;
            $contract->contract_automation_project_status = $settings->settings2_contracts_automation_project_status;
            $contract->contract_automation_create_tasks = $settings->settings2_contracts_automation_create_tasks;
            $contract->contract_automation_project_email_client = $settings->settings2_contracts_automation_project_email_client;
            $contract->contract_automation_create_invoice = $settings->settings2_contracts_automation_create_invoice;
            $contract->contract_automation_invoice_due_date = $invoice_due_days;
            $contract->contract_automation_invoice_email_client = $settings->settings2_contracts_automation_invoice_email_client;
        }

        $contract->save();

        //tags
        $this->tagrepo->add('contract', $contract->doc_id);

        //copy default assigned users for automation
        if ($contract->contract_automation_status == 'enabled') {
            $assigned_users = \App\Models\AutomationAssigned::Where('automationassigned_resource_type', 'contract')
                ->Where('automationassigned_resource_id', 0)
                ->get();

            foreach ($assigned_users as $user) {
                $assigned = new \App\Models\AutomationAssigned();
                $assigned->automationassigned_resource_type = 'contract';
                $assigned->automationassigned_resource_id = $contract->doc_id;
                $assigned->automationassigned_userid = $user->automationassigned_userid;
                $assigned->save();
            }
        }

        //options
        if (is_numeric(request('contract_template'))) {
            if ($template = \App\Models\ContractTemplate::Where('contract_template_id', request('contract_template'))->first()) {
                $contract->doc_heading_color = $template->contract_template_heading_color;
                $contract->doc_title_color = $template->contract_template_title_color;
                $contract->doc_body = $template->contract_template_body;
                $contract->save();
            }
        }

        //create an estimate record
        $estimate_id = $this->estimaterepo->createContractEstimate($contract->doc_id);

        //get the contract object (friendly for rendering in blade template)
        $contracts = $this->contractrepo->search($contract->doc_id);

        //counting rows
        $rows = $this->contractrepo->search();
        $count = $rows->total();

        //reponse payload
        $payload = [
            'contracts' => $contracts,
            'id' => $contract->doc_id,
            'count' => $count,
        ];

        //fire stored event
        event(new \App\Events\Contracts\ContractStored(request(), $contract->doc_id, $payload));

        //process reponse
        return new StoreResponse($payload);
    }

    /**
     * Show the resource
     * @return blade view | ajax view
     */
    public function show(EstimateGeneratorRepository $estimategenerator, $id) {

        //defaults
        $has_estimate = false;

        $payload = [];

        //refresh contract
        $this->contractrepo->refreshContract($id);

        //get the project
        $documents = $this->contractrepo->search($id);
        $document = $documents->first();

        //get the estimate
        if ($estimate = \App\Models\Estimate::Where('bill_contractid', $id)->Where('bill_estimate_type', 'document')->first()) {
            request()->merge([
                'generate_estimate_mode' => 'document',
            ]);
            if ($payload = $estimategenerator->generate($estimate->bill_estimateid)) {
                $has_estimate = true;
            }
        }

        //mark events as read
        \App\Models\EventTracking::where('parent_id', $id)
            ->where('parent_type', 'contract')
            ->where('eventtracking_userid', auth()->id())
            ->update(['eventtracking_status' => 'read']);

        //custom fields
        $customfields = \App\Models\CustomField::Where('customfields_type', 'clients')->get();

        //set page
        $page = $this->pageSettings('contract', $document);

        //payload
        $payload += [
            'document' => $document,
            'page' => $page,
            'customfields' => $customfields,
            'estimate' => $estimate,
            'has_estimate' => $has_estimate,
        ];

        //show the view
        return new ShowPreviewResponse($payload);
    }

    /**
     * Show the resource on a public url
     * @return blade view | ajax view
     */
    public function showPublic(EstimateGeneratorRepository $estimategenerator, $id) {

        //defaults
        $has_estimate = false;

        $payload = [];

        //get contract
        $contract = \App\Models\Contract::Where('doc_unique_id', $id)->first();

        //contract not found
        if (!$contract) {
            abort(404);
        }

        //authenticated - redirect to authenticated view
        $this->middleware('auth');

        //Filtering
        $this->middleware('contractsMiddlewareFiltering')->only([
            'index',
        ]);
        if (auth()->check()) {

            $this->middleware("contractsMiddlewareFiltering")->only([
                'index',
            ]);
            return redirect(url('contracts/' . $contract->doc_id));
        }

        //refresh contract
        $this->contractrepo->refreshContract($contract->doc_id);

        //get the project
        $documents = $this->contractrepo->search($contract->doc_id);
        $document = $documents->first();

        //get the estimate
        if ($estimate = \App\Models\Estimate::Where('bill_contractid', $contract->doc_id)->Where('bill_estimate_type', 'document')->first()) {
            request()->merge([
                'generate_estimate_mode' => 'document',
            ]);
            if ($payload = $estimategenerator->generate($estimate->bill_estimateid)) {
                $has_estimate = true;
            }
        }

        //custom fields
        $customfields = \App\Models\CustomField::Where('customfields_type', 'clients')->get();

        //set page
        $page = $this->pageSettings('contract', $document);

        //set visibility for public view
        config(['visibility.viewing' => 'public']);

        //set signature visibility for guest users
        $this->contractrepo->visibilitySignatures($document, 'public');

        //payload
        $payload += [
            'document' => $document,
            'page' => $page,
            'customfields' => $customfields,
            'estimate' => $estimate,
            'has_estimate' => $has_estimate,
        ];

        //show the view
        return new ShowPreviewResponse($payload);
    }

    /**
     * edit the cover
     * @return blade view | ajax view
     */
    public function editingContract(CategoryRepository $categoryrepo, $id) {

        //refresh contract
        $this->contractrepo->refreshContract($id);

        //get the project
        $documents = $this->contractrepo->search($id);
        $document = $documents->first();

        //make sure we have an estimate record
        $estimate_id = $this->estimaterepo->createContractEstimate($id);

        //get the estimate (or create if does not exist)
        if (!$estimate = \App\Models\Estimate::Where('bill_contractid', $id)->Where('bill_estimate_type', 'document')->first()) {
            //create an estimate record
            $this->estimaterepo->createContractEstimate($document->doc_id);
            $estimate = \App\Models\Estimate::Where('bill_contractid', $id)->Where('bill_estimate_type', 'document')->first();
        }

        //client categories
        $categories = $categoryrepo->get('contract');

        //custom fields - only enabled fields
        $customfields = \App\Models\CustomField::Where('customfields_type', 'clients')
            ->where('customfields_status', 'enabled')
            ->orderBy('customfields_position', 'asc')
            ->get();

        //set page
        $page = $this->pageSettings('contract', $document);

        //payload
        $payload = [
            'document' => $document,
            'page' => $page,
            'categories' => $categories,
            'customfields' => $customfields,
            'estimate' => $estimate,
            'mode' => 'editing',
        ];

        //show the view
        return new ShowEditResponse($payload);
    }

    /**
     * Remove the specified contract from storage.
     * @return \Illuminate\Http\Response
     */
    public function destroy() {

        //delete each record in the array
        $allrows = [];
        foreach (request('ids') as $id => $value) {
            //only checked contracts
            if ($value == 'on') {
                //get the contract
                $contract = \App\Models\Contract::Where('doc_id', $id)->first();
                //add to array
                $allrows[] = $id;
            }
        }

        //fire deleting event
        event(new \App\Events\Contracts\ContractDeleting(request(), $allrows));

        //delete contracts
        foreach ($allrows as $id) {
            if ($contract = \App\Models\Contract::Where('doc_id', $id)->first()) {
                $contract->delete();
            }
        }

        //reponse payload
        $payload = [
            'allrows' => $allrows,
            'stats' => $this->statsWidget(),
        ];

        //fire deleted event
        event(new \App\Events\Contracts\ContractDeleted(request(), $allrows, $payload));

        //generate a response
        return new DestroyResponse($payload);
    }

    /**
     * Bulk change category for contracts
     * @url baseusr/contracts/bulkdelete
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete() {

        //validation - post
        if (!is_array(request('contract'))) {
            abort(409);
        }

        //collect contract IDs
        $contract_ids = [];
        foreach (request('contract') as $contract_id => $value) {
            if ($value == 'on') {
                $contract_ids[] = $contract_id;
            }
        }

        //fire bulk deleting event
        event(new \App\Events\Contracts\ContractBulkDeleting(request(), $contract_ids));

        //loop through and delete each one
        $deleted = 0;
        foreach ($contract_ids as $contract_id) {
            //get the contract
            if ($contracts = $this->contractrepo->search($contract_id)) {
                //remove the contract
                $contracts->first()->delete();
                //hide and remove row
                $jsondata['dom_visibility'][] = [
                    'selector' => '#contract_' . $contract_id,
                    'action' => 'slideup-remove',
                ];
            }
            $deleted++;
        }

        //something went wrong
        if ($deleted == 0) {
            abort(409);
        }

        //success
        $jsondata['notification'] = ['type' => 'success', 'value' => 'Request has been completed'];

        //payload
        $payload = $jsondata;

        //fire bulk deleted event
        event(new \App\Events\Contracts\ContractBulkDeleted(request(), $contract_ids, $payload));

        //ajax response
        return response()->json($jsondata);
    }

    /**
     * Show the form for updating the contract
     * @param object CategoryRepository instance of the repository
     * @return \Illuminate\Http\Response
     */
    public function changeCategory(CategoryRepository $categoryrepo) {

        //get all contract categories
        $categories = $categoryrepo->get('contract');

        //reponse payload
        $payload = [
            'categories' => $categories,
        ];

        //show the form
        return new ChangeCategoryResponse($payload);
    }

    /**
     * Show the form for updating the contract
     * @param object CategoryRepository instance of the repository
     * @return \Illuminate\Http\Response
     */
    public function changeCategoryUpdate(CategoryRepository $categoryrepo) {

        //validate the category exists
        if (!\App\Models\Category::Where('category_id', request('category'))
            ->Where('category_type', 'contract')
            ->first()) {
            abort(409, __('lang.category_not_found'));
        }

        //collect contract IDs
        $contract_ids = [];
        foreach (request('ids') as $contract_id => $value) {
            if ($value == 'on') {
                $contract_ids[] = $contract_id;
            }
        }

        //fire category changing event
        event(new \App\Events\Contracts\ContractCategoryChanging(request(), $contract_ids));

        //update each contract
        $allrows = [];
        foreach ($contract_ids as $contract_id) {
            if ($contract = \App\Models\Contract::Where('doc_id', $contract_id)->first()) {
                //update the category
                $contract->doc_categoryid = request('category');
                $contract->save();
                //get the contract in rendering friendly format
                $contracts = $this->contractrepo->search($contract_id);
                //add to array
                $allrows[] = $contracts;
            }
        }

        //reponse payload
        $payload = [
            'allrows' => $allrows,
        ];

        //fire category changed event
        event(new \App\Events\Contracts\ContractCategoryChanged(request(), $contract_ids, $payload));

        //show the form
        return new ChangeCategoryUpdateResponse($payload);
    }

    /**
     * publish the resource
     * @return blade view | ajax view
     */
    public function publish($id) {

        //fire publishing event
        event(new \App\Events\Contracts\ContractPublishing(request(), $id));

        if (!$this->contractrepo->publish($id)) {
            abort(409, __('lang.error_request_could_not_be_completed'));
        }

        //payload
        $payload = [];

        //fire published event
        event(new \App\Events\Contracts\ContractPublished(request(), $id, $payload));

        //return the reposnse
        return new PublishResponse($payload);
    }

    /**
     * schedule an contract for publising later
     * @param int $id contract id
     * @return \Illuminate\Http\Response
     */
    public function publishScheduled($id) {

        //does the contract exist
        if (!$contract = \App\Models\Contract::Where('doc_id', $id)->first()) {
            abort(404);
        }

        //custom error messages
        $messages = [
            'publishing_option_date.required' => __('lang.schedule_date') . '-' . __('lang.is_required'),
        ];

        //validate
        $validator = Validator::make(request()->all(), [
            'publishing_option_date' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (strtotime($value) < strtotime(now()->toDateString())) {
                        return $fail(__('lang.schedule_date_cannot_be_past'));
                    }
                },
            ],
        ], $messages);

        //errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $messages = '';
            foreach ($errors->all() as $message) {
                $messages .= "<li>$message</li>";
            }
            //redirect and show error (to make show the publish dropdown works again)
            request()->session()->flash('error-notification', __('lang.error') . ': ' . $messages);
            $jsondata['redirect_url'] = url("/contracts/$id");
            return response()->json($jsondata);
        }

        //fire publish scheduling event
        event(new \App\Events\Contracts\ContractPublishScheduling(request(), $id));

        //secdule the contract
        $contract->doc_publishing_type = 'scheduled';
        $contract->doc_publishing_scheduled_date = request('publishing_option_date');
        $contract->doc_publishing_scheduled_status = 'pending';
        $contract->doc_publishing_scheduled_log = '';
        $contract->save();

        //reponse payload
        $payload = [
            'id' => $id,
        ];

        //fire publish scheduled event
        event(new \App\Events\Contracts\ContractPublishScheduled(request(), $id, $payload));

        //response
        return new PublishScheduledResponse($payload);
    }

    /**
     * email the resource
     * @return blade view | ajax view
     */
    public function resendEmail($id) {

        //fire email resending event
        event(new \App\Events\Contracts\ContractEmailResending(request(), $id));

        //get the project
        $documents = $this->contractrepo->search($id);
        $document = $documents->first();

        //get the estimate
        if ($estimate = \App\Models\Estimate::Where('bill_contractid', $id)->Where('bill_estimate_type', 'document')->first()) {
            $value = $estimate->bill_final_amount;
        } else {
            $value = 0;
        }

        //mark as published (fro draft status)
        if ($document->doc_status == 'draft') {
            $document->doc_status = 'new';
            $document->doc_date_published = now();
        }
        $document->doc_date_last_emailed = now();
        $document->save();

        /** ----------------------------------------------
         * send email - client users - [queued]
         * ----------------------------------------------*/
        if ($document->docresource_type == 'client') {
            $data = [
                'user_type' => 'client',
                'contract_value' => $value,
            ];
            if ($users = $this->userrepo->getClientUsers($document->doc_client_id, 'owner', 'collection')) {
                foreach ($users as $user) {
                    $mail = new \App\Mail\ContractCreated($user, $data, $document);
                    $mail->build();
                }
            }
        }

        //payload
        $payload = [];

        //fire email resent event
        event(new \App\Events\Contracts\ContractEmailResent(request(), $id, $payload));

        //return the reposnse
        return new EmailResponse($payload);
    }

    /**
     * change the resource status
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus($id) {

        //valid statuses
        $valid_statuses = [
            'accepted',
            'declined',
            'revised',
            'draft',
            'new',
        ];

        //validate
        if (!in_array(request('status'), $valid_statuses)) {
            abort(409, __('lang.invalid_status'));
        }

        //fire status changing event
        event(new \App\Events\Contracts\ContractStatusChanging(request(), $id));

        //get contract
        $contract = \App\Models\Contract::Where('doc_id', $id)->first();

        //update
        $contract->doc_status = request('status');
        $contract->doc_signed_date = null;
        $contract->doc_signed_first_name = null;
        $contract->doc_signed_last_name = null;
        $contract->doc_signed_signature_directory = null;
        $contract->doc_signed_signature_filename = null;
        $contract->doc_signed_ip_address = null;
        $contract->save();

        //get the refreshed contract
        $contracts = $this->contractrepo->search($id);
        $contract = $contracts->first();

        //reponse payload
        $payload = [
            'page' => $this->pageSettings(),
            'id' => $id,
            'contracts' => $contracts,
            'contract' => $contract,
            'stats' => $this->statsWidget(),
        ];

        //fire status changed event
        event(new \App\Events\Contracts\ContractStatusChanged(request(), $id, $payload));

        //return the reposnse
        return new ChangeStatusResponse($payload);
    }

    /**
     * Show the form for attaching a project to an contract
     * @return \Illuminate\Http\Response
     */
    public function attachProject() {

        //get client id
        $client_id = request('client_id');

        //reponse payload
        $payload = [
            'projects_feed_url' => url("/feed/projects?ref=clients_projects&client_id=$client_id"),
            'type' => 'form',
        ];

        //show the form
        return new AttachProjectResponse($payload);
    }

    /**
     * attach a project to an contract
     * @return \Illuminate\Http\Response
     */
    public function attachProjectUpdate() {

        //validate the contract exists
        $contract = \App\Models\Contract::Where('doc_id', request()->route('contract'))->first();

        //validate the project exists
        if (!$project = \App\Models\Project::Where('project_id', request('attach_project_id'))->first()) {
            abort(409, __('lang.item_not_found'));
        }

        //fire project attaching event
        event(new \App\Events\Contracts\ContractProjectAttaching(request(), request()->route('contract')));

        //update the contract
        $contract->doc_project_id = request('attach_project_id');
        $contract->doc_client_id = $project->project_clientid;
        $contract->save();

        //get refreshed contract
        $contracts = $this->contractrepo->search(request()->route('contract'));
        $contract = $contracts->first();

        //refresh contract
        $this->contractrepo->refreshcontract($contract);

        //reponse payload
        $payload = [
            'contracts' => $contracts,
            'contract' => $contract,
            'type' => 'update',
        ];

        //fire project attached event
        event(new \App\Events\Contracts\ContractProjectAttached(request(), request()->route('contract'), $payload));

        //show the form
        return new AttachProjectResponse($payload);
    }

    /**
     * dettach contract from a project
     * @return \Illuminate\Http\Response
     */
    public function dettachProject() {

        //validate the contract exists
        $contract = \App\Models\contract::Where('doc_id', request()->route('contract'))->first();

        //update the contract
        $contract->doc_project_id = null;
        $contract->save();

        //get refreshed contract
        $contracts = $this->contractrepo->search(request()->route('contract'));

        //reponse payload
        $payload = [
            'contracts' => $contracts,
            'contract' => $contract,
            'type' => 'update',
        ];

        //fire project detached event
        event(new \App\Events\Contracts\ContractProjectDetached(request(), request()->route('contract'), $payload));

        //show the form
        return new AttachProjectResponse($payload);
    }

    /**
     * show the form to sign a resource
     *
     * @return \Illuminate\Http\Response
     */
    public function signTeam($id) {

        //get the contract
        $contract = \App\Models\Contract::Where('doc_unique_id', $id)->first();

        //payload for event
        $payload = ['contract' => $contract];

        //fire event
        event(new \App\Events\Contracts\Responses\ContractSignTeam(request(), $payload));

        //page
        $html = view('pages/documents/components/contract/sign', compact('contract'))->render();
        $jsondata['dom_html'][] = [
            'selector' => '#commonModalBody',
            'action' => 'replace',
            'value' => $html,
        ];

        //postrun
        $jsondata['postrun_functions'][] = [
            'value' => 'NXSignDocument',
        ];

        //render
        return response()->json($jsondata);
    }

    /**
     * sign the contract
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function signTeamAction(ContractAutomationRepository $automationrepo, $id) {

        //get the contract
        $contract = \App\Models\Contract::Where('doc_unique_id', $id)->first();

        //custom error messages
        $messages = [
            'doc_signed_first_name.required' => __('lang.first_name') . ' - ' . __('lang.is_required'),
            'doc_signed_last_name.required' => __('lang.last_name') . ' - ' . __('lang.is_required'),
            'signature_code.required' => __('lang.signature') . ' - ' . __('lang.is_required'),
        ];

        //validate
        $validator = Validator::make(request()->all(), [
            'signature_code' => [
                'required',
            ],
            'doc_signed_first_name' => [
                'required',
            ],
            'doc_signed_last_name' => [
                'required',
            ],
        ], $messages);

        //errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $messages = '';
            foreach ($errors->all() as $message) {
                $messages .= "<li>$message</li>";
            }
            abort(409, $messages);
        }

        //fire team signing event
        event(new \App\Events\Contracts\ContractTeamSigning(request(), $contract->doc_id));

        //generate the signature image
        $signature = $this->saveSignature();

        //update contract
        $contract->doc_provider_signed_date = now();
        $contract->doc_provider_signed_userid = auth()->id();
        $contract->doc_provider_signed_first_name = auth()->user()->first_name;
        $contract->doc_provider_signed_last_name = auth()->user()->last_name;
        $contract->doc_provider_signed_signature_directory = $signature['directory'];
        $contract->doc_provider_signed_signature_filename = $signature['file_name'];
        $contract->doc_provider_signed_ip_address = request()->ip();
        $contract->doc_provider_signed_status = 'signed';
        $contract->save();

        //get the refreshed contract
        $contract = \App\Models\Contract::Where('doc_unique_id', $id)->first();

        //set signatures visibility
        $this->contractrepo->visibilitySignatures($contract, 'edit');

        /** --------------------------------------------------------
         * [automation] - contract signed
         * --------------------------------------------------------*/
        $automationrepo->process($contract);

        //reponse payload
        $payload = [
            'document' => $contract,
        ];

        //fire team signed event
        event(new \App\Events\Contracts\ContractTeamSigned(request(), $contract->doc_id, $payload));

        //return the reposnse
        return new SignatureResponse($payload);
    }

    /**
     * show the form to sign a resource
     *
     * @return \Illuminate\Http\Response
     */
    public function signClient($id) {

        //get the contract
        $contract = \App\Models\Contract::Where('doc_unique_id', $id)->first();

        //payload for event
        $payload = ['contract' => $contract];

        //fire event
        event(new \App\Events\Contracts\Responses\ContractSignClient(request(), $payload));

        //page
        $html = view('pages/documents/components/contract/sign', compact('contract'))->render();
        $jsondata['dom_html'][] = [
            'selector' => '#commonModalBody',
            'action' => 'replace',
            'value' => $html,
        ];

        //postrun
        $jsondata['postrun_functions'][] = [
            'value' => 'NXSignDocument',
        ];

        //render
        return response()->json($jsondata);
    }

    /**
     * sign the contract
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function signClientAction(ContractAutomationRepository $automationrepo, $id) {

        //get the contract
        $contract = \App\Models\Contract::Where('doc_unique_id', $id)->first();

        //custom error messages
        $messages = [
            'doc_signed_first_name.required' => __('lang.first_name') . ' - ' . __('lang.is_required'),
            'doc_signed_last_name.required' => __('lang.last_name') . ' - ' . __('lang.is_required'),
            'signature_code.required' => __('lang.signature') . ' - ' . __('lang.is_required'),
        ];

        //validate
        $validator = Validator::make(request()->all(), [
            'signature_code' => [
                'required',
            ],
            'doc_signed_first_name' => [
                'required',
            ],
            'doc_signed_last_name' => [
                'required',
            ],
        ], $messages);

        //errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $messages = '';
            foreach ($errors->all() as $message) {
                $messages .= "<li>$message</li>";
            }
            abort(409, $messages);
        }

        //fire client signing event
        event(new \App\Events\Contracts\ContractClientSigning(request(), $contract->doc_id));

        //generate the signature image
        $signature = $this->saveSignature();

        //update contract
        $contract->doc_signed_date = now();
        $contract->doc_signed_userid = (auth()->check()) ? auth()->id() : null;
        $contract->doc_signed_first_name = request('doc_signed_first_name');
        $contract->doc_signed_last_name = request('doc_signed_last_name');
        $contract->doc_signed_signature_directory = $signature['directory'];
        $contract->doc_signed_signature_filename = $signature['file_name'];
        $contract->doc_signed_ip_address = request()->ip();
        $contract->doc_signed_status = 'signed';
        $contract->save();

        //refresh contract
        $this->contractrepo->refreshContract($contract->doc_id);

        //get refreshed contract
        $contract = \App\Models\Contract::Where('doc_unique_id', $id)->first();

        /** ----------------------------------------------
         * record event [comment]
         * see database table to details of each key
         * ----------------------------------------------*/
        $data = [
            'event_creatorid' => -1,
            'event_creator_name' => $contract->doc_signed_first_name, //(optional) non-registered users
            'event_item' => 'contract',
            'event_item_id' => $contract->doc_id,
            'event_item_lang' => 'event_signed_contract',
            'event_item_content' => $contract->doc_title,
            'event_item_content2' => '',
            'event_clientid' => $contract->doc_client_id,
            'event_parent_type' => 'contract',
            'event_parent_id' => $contract->doc_id,
            'event_parent_title' => $contract->doc_title,
            'event_show_item' => 'yes',
            'event_show_in_timeline' => 'yes',
            'eventresource_type' => 'contract',
            'eventresource_id' => $contract->doc_id,
            'event_notification_category' => 'notifications_billing_activity',
        ];
        //record event
        if ($event_id = $this->eventrepo->create($data)) {
            //get users
            $users = $this->userrepo->mailingListProposals();
            //dd($users);
            //record notification
            $emailusers = $this->trackingrepo->recordEvent($data, $users, $event_id);
        }

        /** ----------------------------------------------
         * send email [comment
         * ----------------------------------------------*/
        if (isset($emailusers) && is_array($emailusers)) {
            //send to users
            if ($users = \App\Models\User::WhereIn('id', $emailusers)->get()) {
                foreach ($users as $user) {
                    $mail = new \App\Mail\ContractSigned($user, [], $contract);
                    $mail->build();
                }
            }
        }

        /** --------------------------------------------------------
         * [automation] - contract signed
         * --------------------------------------------------------*/
        $automationrepo->process($contract);

        //redirect
        if (auth()->check()) {
            $jsondata['redirect_url'] = url("contracts/view/$id");
        } else {
            $jsondata['redirect_url'] = url("contracts/view/" . $contract->doc_unique_id . "?action=preview");
        }

        //thank you message
        request()->session()->flash('success-notification-long', __('lang.request_has_been_completed'));

        //payload
        $payload = $jsondata;

        //fire client signed event
        event(new \App\Events\Contracts\ContractClientSigned(request(), $contract->doc_id, $payload));

        //ajax response
        return response()->json($jsondata);
    }

    /**
     * show the form to sign a resource for guest users
     *
     * @return \Illuminate\Http\Response
     */
    public function signGuest($id) {

        //get the contract
        $contract = \App\Models\Contract::Where('doc_unique_id', $id)->first();

        //contract not found
        if (!$contract) {
            abort(404, __('lang.contract_not_found'));
        }

        //check contract status allows signing
        if ($contract->doc_signed_status == 'signed') {
            abort(409, __('lang.contract_already_signed'));
        }

        //payload for event
        $payload = ['contract' => $contract];

        //fire event
        event(new \App\Events\Contracts\Responses\ContractSignClient(request(), $payload));

        //page
        $html = view('pages/documents/components/contract/sign', compact('contract'))->render();
        $jsondata['dom_html'][] = [
            'selector' => '#commonModalBody',
            'action' => 'replace',
            'value' => $html,
        ];

        //postrun
        $jsondata['postrun_functions'][] = [
            'value' => 'NXSignDocument',
        ];

        //render
        return response()->json($jsondata);
    }

    /**
     * sign the contract for guest users
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function signGuestAction(ContractAutomationRepository $automationrepo, $id) {

        //get the contract
        $contract = \App\Models\Contract::Where('doc_unique_id', $id)->first();

        //contract not found
        if (!$contract) {
            abort(404, __('lang.contract_not_found'));
        }

        //check contract status allows signing
        if ($contract->doc_signed_status == 'signed') {
            abort(409, __('lang.contract_already_signed'));
        }

        //custom error messages
        $messages = [
            'doc_signed_first_name.required' => __('lang.first_name') . ' - ' . __('lang.is_required'),
            'doc_signed_last_name.required' => __('lang.last_name') . ' - ' . __('lang.is_required'),
            'signature_code.required' => __('lang.signature') . ' - ' . __('lang.is_required'),
        ];

        //validate
        $validator = Validator::make(request()->all(), [
            'signature_code' => [
                'required',
            ],
            'doc_signed_first_name' => [
                'required',
            ],
            'doc_signed_last_name' => [
                'required',
            ],
        ], $messages);

        //errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $messages = '';
            foreach ($errors->all() as $message) {
                $messages .= "<li>$message</li>";
            }
            abort(409, $messages);
        }

        //fire client signing event
        event(new \App\Events\Contracts\ContractClientSigning(request(), $contract->doc_id));

        //generate the signature image
        $signature = $this->saveSignature();

        //update contract
        $contract->doc_signed_date = now();
        $contract->doc_signed_userid = null;
        $contract->doc_signed_first_name = request('doc_signed_first_name');
        $contract->doc_signed_last_name = request('doc_signed_last_name');
        $contract->doc_signed_signature_directory = $signature['directory'];
        $contract->doc_signed_signature_filename = $signature['file_name'];
        $contract->doc_signed_ip_address = request()->ip();
        $contract->doc_signed_status = 'signed';
        $contract->save();

        //refresh contract
        $this->contractrepo->refreshContract($contract->doc_id);

        //get refreshed contract
        $contract = \App\Models\Contract::Where('doc_unique_id', $id)->first();

        /** ----------------------------------------------
         * record event [comment]
         * see database table to details of each key
         * ----------------------------------------------*/
        $data = [
            'event_creatorid' => -1,
            'event_creator_name' => $contract->doc_signed_first_name . ' ' . $contract->doc_signed_last_name,
            'event_item' => 'contract',
            'event_item_id' => $contract->doc_id,
            'event_item_lang' => 'event_signed_contract',
            'event_item_content' => $contract->doc_title,
            'event_item_content2' => '',
            'event_clientid' => $contract->doc_client_id,
            'event_parent_type' => 'contract',
            'event_parent_id' => $contract->doc_id,
            'event_parent_title' => $contract->doc_title,
            'event_show_item' => 'yes',
            'event_show_in_timeline' => 'yes',
            'eventresource_type' => 'contract',
            'eventresource_id' => $contract->doc_id,
            'event_notification_category' => 'notifications_billing_activity',
        ];
        //record event
        if ($event_id = $this->eventrepo->create($data)) {
            //get users
            $users = $this->userrepo->mailingListProposals();
            //record notification
            $emailusers = $this->trackingrepo->recordEvent($data, $users, $event_id);
        }

        /** ----------------------------------------------
         * send email [comment
         * ----------------------------------------------*/
        if (isset($emailusers) && is_array($emailusers)) {
            //send to users
            if ($users = \App\Models\User::WhereIn('id', $emailusers)->get()) {
                foreach ($users as $user) {
                    $mail = new \App\Mail\ContractSigned($user, [], $contract);
                    $mail->build();
                }
            }
        }

        /** --------------------------------------------------------
         * [automation] - contract signed
         * --------------------------------------------------------*/
        $automationrepo->process($contract);

        //redirect to public view
        $jsondata['redirect_url'] = url("contracts/view/" . $contract->doc_unique_id);

        //thank you message
        request()->session()->flash('success-notification-long', __('lang.request_has_been_completed'));

        //payload
        $payload = $jsondata;

        //fire client signed event
        event(new \App\Events\Contracts\ContractClientSigned(request(), $contract->doc_id, $payload));

        //ajax response
        return response()->json($jsondata);
    }

    /**
     * show the form to sign a resource when client is present in person
     *
     * @return \Illuminate\Http\Response
     */
    public function signClientInPerson($id) {

        //get the contract
        $contract = \App\Models\Contract::Where('doc_unique_id', $id)->first();

        //contract not found
        if (!$contract) {
            abort(404, __('lang.contract_not_found'));
        }

        //check contract status allows signing
        if ($contract->doc_signed_status == 'signed') {
            abort(409, __('lang.contract_already_signed'));
        }

        //get client
        $client = \App\Models\Client::Where('client_id', $contract->doc_client_id)->first();
        config([
            'signining.first_name' => $client->owner->first_name,
            'signining.last_name' => $client->owner->last_name,
        ]);

        //payload for event
        $payload = [
            'contract' => $contract,
            'first_name' => $client->owner->first_name,
            'last_name' => $client->owner->last_name,
        ];

        //fire event
        event(new \App\Events\Contracts\Responses\ContractSignClient(request(), $payload));

        //page
        $html = view('pages/documents/components/contract/sign', compact('contract'))->render();
        $jsondata['dom_html'][] = [
            'selector' => '#commonModalBody',
            'action' => 'replace',
            'value' => $html,
        ];

        //postrun
        $jsondata['postrun_functions'][] = [
            'value' => 'NXSignDocument',
        ];

        //render
        return response()->json($jsondata);
    }

    /**
     * sign the contract when client is present in person
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function signClientInPersonAction(ContractAutomationRepository $automationrepo, $id) {

        //get the contract
        $contract = \App\Models\Contract::Where('doc_unique_id', $id)->first();

        //contract not found
        if (!$contract) {
            abort(404, __('lang.contract_not_found'));
        }

        //check contract status allows signing
        if ($contract->doc_signed_status == 'signed') {
            abort(409, __('lang.contract_already_signed'));
        }

        //custom error messages
        $messages = [
            'doc_signed_first_name.required' => __('lang.first_name') . ' - ' . __('lang.is_required'),
            'doc_signed_last_name.required' => __('lang.last_name') . ' - ' . __('lang.is_required'),
            'signature_code.required' => __('lang.signature') . ' - ' . __('lang.is_required'),
        ];

        //validate
        $validator = Validator::make(request()->all(), [
            'signature_code' => [
                'required',
            ],
            'doc_signed_first_name' => [
                'required',
            ],
            'doc_signed_last_name' => [
                'required',
            ],
        ], $messages);

        //errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $messages = '';
            foreach ($errors->all() as $message) {
                $messages .= "<li>$message</li>";
            }
            abort(409, $messages);
        }

        //fire client signing event
        event(new \App\Events\Contracts\ContractClientSigning(request(), $contract->doc_id));

        //try to find matching client user based on name
        $client_user = \App\Models\User::where('clientid', $contract->doc_client_id)
            ->whereRaw('LOWER(first_name) = ?', [strtolower(request('doc_signed_first_name'))])
            ->whereRaw('LOWER(last_name) = ?', [strtolower(request('doc_signed_last_name'))])
            ->first();

        //set user id - matching client user or system user (0)
        $signed_userid = $client_user ? $client_user->id : -1;

        //generate the signature image
        $signature = $this->saveSignature();

        //update contract
        $contract->doc_signed_date = now();
        $contract->doc_signed_userid = $signed_userid;
        $contract->doc_signed_first_name = request('doc_signed_first_name');
        $contract->doc_signed_last_name = request('doc_signed_last_name');
        $contract->doc_signed_signature_directory = $signature['directory'];
        $contract->doc_signed_signature_filename = $signature['file_name'];
        $contract->doc_signed_ip_address = request()->ip();
        $contract->doc_signed_status = 'signed';
        $contract->save();

        //refresh contract
        $this->contractrepo->refreshContract($contract->doc_id);

        //get refreshed contract
        $contract = \App\Models\Contract::Where('doc_unique_id', $id)->first();

        /** ----------------------------------------------
         * record event [comment]
         * see database table to details of each key
         * ----------------------------------------------*/
        $data = [
            'event_creatorid' => $signed_userid,
            'event_creator_name' => $contract->doc_signed_first_name . ' ' . $contract->doc_signed_last_name,
            'event_item' => 'contract',
            'event_item_id' => $contract->doc_id,
            'event_item_lang' => 'event_signed_contract',
            'event_item_content' => $contract->doc_title,
            'event_item_content2' => '',
            'event_clientid' => $contract->doc_client_id,
            'event_parent_type' => 'contract',
            'event_parent_id' => $contract->doc_id,
            'event_parent_title' => $contract->doc_title,
            'event_show_item' => 'yes',
            'event_show_in_timeline' => 'yes',
            'eventresource_type' => 'contract',
            'eventresource_id' => $contract->doc_id,
            'event_notification_category' => 'notifications_billing_activity',
        ];
        //record event
        if ($event_id = $this->eventrepo->create($data)) {
            //get users
            $users = $this->userrepo->mailingListProposals();
            //record notification
            $emailusers = $this->trackingrepo->recordEvent($data, $users, $event_id);
        }

        /** ----------------------------------------------
         * send email [comment
         * ----------------------------------------------*/
        if (isset($emailusers) && is_array($emailusers)) {
            //send to users
            if ($users = \App\Models\User::WhereIn('id', $emailusers)->get()) {
                foreach ($users as $user) {
                    $mail = new \App\Mail\ContractSigned($user, [], $contract);
                    $mail->build();
                }
            }
        }

        /** --------------------------------------------------------
         * [automation] - contract signed
         * --------------------------------------------------------*/
        $automationrepo->process($contract);

        //redirect to authenticated contract view
        $jsondata['redirect_url'] = url("contracts/" . $contract->doc_id);

        //thank you message
        request()->session()->flash('success-notification-long', __('lang.request_has_been_completed'));

        //payload
        $payload = $jsondata;

        //fire client signed event
        event(new \App\Events\Contracts\ContractClientSigned(request(), $contract->doc_id, $payload));

        //ajax response
        return response()->json($jsondata);
    }

    /**
     * delete team signature
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function signDeleteSignature($id) {

        //get the contract
        $contract = \App\Models\Contract::Where('doc_unique_id', $id)->first();

        //check if the client has not already signed the contract
        if ($contract->doc_signed_status == 'signed') {
            abort(409, __('lang.contract_signature_cannot_be_delete'));
        }

        //update contract
        $contract->doc_provider_signed_date = null;
        $contract->doc_provider_signed_userid = null;
        $contract->doc_provider_signed_first_name = '';
        $contract->doc_provider_signed_last_name = '';
        $contract->doc_provider_signed_signature_directory = '';
        $contract->doc_provider_signed_signature_filename = '';
        $contract->doc_provider_signed_ip_address = '';
        $contract->doc_provider_signed_status = 'unsigned';
        $contract->save();

        //get the refreshed contract
        $contract = \App\Models\Contract::Where('doc_unique_id', $id)->first();

        //set signatures visibility
        $this->contractrepo->visibilitySignatures($contract, 'edit');

        //reponse payload
        $payload = [
            'document' => $contract,
        ];

        //fire signature deleted event
        event(new \App\Events\Contracts\ContractSignatureDeleted(request(), $contract->doc_id, $payload));

        //return the reposnse
        return new SignatureResponse($payload);
    }

    /**
     * save signature as an image
     * @return array
     */
    public function saveSignature() {

        //unique file id & directory name
        $directory = Str::random(40);
        $file_name = 'signature.png';
        $file_path = "files/$directory/$file_name";
        $file_full_path = path_storage() . '/' . $file_path;

        //create signature image
        $signature_data = request('signature_code');
        $encoded_image = explode(",", $signature_data)[1];
        $decoded_image = base64_decode($encoded_image);

        //save file to directory
        Storage::put($file_path, $decoded_image);

        //trim white spaces from the image: https://image.intervention.io/v2/api/trim
        try {
            Image::make($file_full_path)->trim('top-left', null, 60)->save();
        } catch (NotReadableException $e) {
            Log::error("Unable to crop signature image", ['process' => '[accept-contract]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        }

        return [
            'directory' => $directory,
            'file_name' => $file_name,
            'file_path' => $file_path,
        ];
    }

    /**
     * data for the stats widget
     * @return array
     */
    private function statsWidget($data = []) {

        //when a stats panel is clicked, URL filter params must not scope the stats queries,
        //or every panel would reflect the filtered totals instead of its own independent value.
        //disabling apply_filters here ensures stats always show global figures.
        $apply_filters = (request('source') == 'stats_panels') ? false : true;

        //stats
        $sum_active = $this->contractrepo->search('', ['stats' => 'sum-active', 'apply_filters' => $apply_filters]);
        $count_active = $this->contractrepo->search('', ['stats' => 'count-active', 'apply_filters' => $apply_filters]);
        $count_awaiting_signatures = $this->contractrepo->search('', ['stats' => 'count-awaiting_signatures', 'apply_filters' => $apply_filters]);
        $count_expired = $this->contractrepo->search('', ['stats' => 'count-expired', 'apply_filters' => $apply_filters]);

        //default values
        $stats = [
            [
                'value' => runtimeMoneyFormat($sum_active),
                'title' => __('lang.active'),
                'percentage' => '100%',
                'color' => 'bg-info',
                'active_panel' => 'active',
                'url' => url('contracts?clear-filter=yes&filter_doc_status[]=active&source=stats_panels&active_panel=active'),
            ],
            [
                'value' => $count_active,
                'title' => __('lang.active'),
                'percentage' => '100%',
                'color' => 'bg-success',
                'active_panel' => 'active',
                'url' => url('contracts?clear-filter=yes&filter_doc_status[]=active&source=stats_panels&active_panel=active'),
            ],
            [
                'value' => $count_awaiting_signatures,
                'title' => __('lang.awaiting_signatures'),
                'percentage' => '100%',
                'color' => 'bg-warning',
                'active_panel' => 'awaiting_signatures',
                'url' => url('contracts?clear-filter=yes&filter_doc_status[]=awaiting_signatures&source=stats_panels&active_panel=awaiting_signatures'),
            ],
            [
                'value' => $count_expired,
                'title' => __('lang.expired'),
                'percentage' => '100%',
                'color' => 'bg-danger',
                'active_panel' => 'expired',
                'url' => url('contracts?clear-filter=yes&filter_doc_status[]=expired&source=stats_panels&active_panel=expired'),
            ],
        ];
        //return
        return $stats;
    }

    /**
     * show the form for cloning an project
     * @param object CategoryRepository instance of the repository
     * @return \Illuminate\Http\Response
     */
    public function createClone(CategoryRepository $categoryrepo, $id) {

        //get the project
        $contract = \App\Models\Contract::Where('doc_id', $id)->first();

        //project categories
        $categories = $categoryrepo->get('contract');

        //reponse payload
        $payload = [
            'response' => 'create',
            'contract' => $contract,
            'categories' => $categories,
        ];

        //show the form
        return new CreateCloneResponse($payload);
    }

    /**
     * show the form for cloning an project
     * @param object CategoryRepository instance of the repository
     * @return \Illuminate\Http\Response
     */
    public function storeClone(CloneContractRepository $clonerepo, $id) {

        //fire cloning event
        event(new \App\Events\Contracts\ContractCloning(request(), $id));

        //data
        $data = [
            'doc_id' => $id,
            'doc_title' => request('doc_title'),
            'doc_date_start' => request('doc_date_start'),
            'doc_date_end' => (request()->filled('doc_date_end')) ? request('doc_date_end') : null,
            'docresource_type' => 'client',
            'doc_client_id' => request('doc_client_id'),
            'doc_project_id' => request('doc_project_id'),
            'doc_categoryid' => request('doc_categoryid'),
            'doc_value' => request('doc_value'),
        ];

        //get the project
        if (!$contract = $clonerepo->clone($data)) {
            abort(409, __('lang.error_request_could_not_be_completed'));
        }

        //reponse payload
        $payload = [
            'response' => 'store',
            'contract' => $contract,
        ];

        //fire cloned event
        event(new \App\Events\Contracts\ContractCloned(request(), $contract->doc_id, $payload));

        //show the form
        return new CreateCloneResponse($payload);
    }

    /**
     * toggle pinned state of contracts
     *
     * @return \Illuminate\Http\Response
     */
    public function togglePinning(PinnedRepository $pinrepo, $id) {

        //toggle pin
        $status = $pinrepo->togglePinned($id, 'contract');

        //reponse payload
        $payload = [
            'contract_id' => $id,
            'status' => $status,
        ];

        //fire pinning toggled event
        event(new \App\Events\Contracts\ContractPinningToggled(request(), $id, $payload));

        //generate a response
        return new PinningResponse($payload);
    }

    /**
     * Show the form for editing contract automation
     * @param int $id contract id
     * @return \Illuminate\Http\Response
     */
    public function editAutomation($id) {

        //get the contract
        $contract = $this->contractrepo->search($id);

        //not found
        if (!$contract = $contract->first()) {
            abort(409, __('lang.contract_not_found'));
        }

        //use the data already set for this automation
        if ($contract->contract_automation_status == 'enabled') {
            $contract_automation = [
                'contract_automation_default_status' => $contract->contract_automation_status,
                'contract_automation_create_project' => $contract->contract_automation_create_project,
                'contract_automation_project_status' => $contract->contract_automation_project_status,
                'contract_automation_project_title' => ($contract->contract_automation_project_title != '') ? $contract->contract_automation_project_title : $contract->doc_title,
                'contract_automation_project_email_client' => $contract->contract_automation_project_email_client,
                'contract_automation_create_invoice' => $contract->contract_automation_create_invoice,
                'contract_automation_invoice_email_client' => $contract->contract_automation_invoice_email_client,
                'contract_automation_invoice_due_date' => $contract->contract_automation_invoice_due_date,
                'contract_automation_create_tasks' => $contract->contract_automation_create_tasks,
            ];

            //[automation] assigned users
            $assigned_users = \App\Models\AutomationAssigned::Where('automationassigned_resource_type', 'contract')
                ->Where('automationassigned_resource_id', $id)
                ->get();
        } else {

            //defaults
            $invoice_due_days = config('system.settings2_contracts_automation_invoice_due_date');

            //fetch the client invoice due days
            if (is_numeric($contract->doc_client_id)) {
                if ($client = \App\Models\Client::where('client_id', $contract->doc_client_id)->first()) {
                    $invoice_due_days = $client->client_billing_invoice_due_days ?? config('system.settings2_contracts_automation_invoice_due_date', 7);
                }
            }

            //use the default settings data for this automation
            $contract_automation = [
                'contract_automation_default_status' => 'disabled',
                'contract_automation_create_project' => config('system.settings2_contracts_automation_create_project'),
                'contract_automation_project_status' => config('system.settings2_contracts_automation_project_status'),
                'contract_automation_project_title' => $contract->doc_title,
                'contract_automation_project_email_client' => config('system.settings2_contracts_automation_project_email_client'),
                'contract_automation_create_invoice' => config('system.settings2_contracts_automation_create_invoice'),
                'contract_automation_invoice_email_client' => config('system.settings2_contracts_automation_invoice_email_client'),
                'contract_automation_invoice_due_date' => $invoice_due_days,
                'contract_automation_create_tasks' => config('system.settings2_contracts_automation_create_tasks'),
            ];

            //[automation] settings assigned users
            $assigned_users = \App\Models\AutomationAssigned::Where('automationassigned_resource_type', 'contract')
                ->Where('automationassigned_resource_id', 0)
                ->get();
        }

        $assigned = [];
        foreach ($assigned_users as $user) {
            $assigned[] = $user->automationassigned_userid;
        }

        //reponse payload
        $payload = [
            'page' => $this->pageSettings('edit'),
            'contract' => $contract,
            'contract_automation' => $contract_automation,
            'assigned' => $assigned,
        ];

        //response
        return new EditAutomationResponse($payload);
    }

    /**
     * Update contract automation
     * @param int $id contract id
     * @return \Illuminate\Http\Response
     */
    public function updateAutomation(ContractUpdateAutomation $request, $id) {

        //get the contract
        $contract = \App\Models\Contract::Where('doc_id', $id)->first();

        //not found
        if (!$contract) {
            abort(409, __('lang.contract_not_found'));
        }

        //fire automation updating event
        event(new \App\Events\Contracts\ContractAutomationUpdating(request(), $id));

        //update settings
        $contract->contract_automation_status = request('contract_automation_status');
        $contract->contract_automation_create_project = (request('contract_automation_create_project') == 'on') ? 'yes' : 'no';
        $contract->contract_automation_project_title = request('contract_automation_project_title');
        $contract->contract_automation_project_status = request('contract_automation_project_status');
        $contract->contract_automation_create_tasks = (request('contract_automation_create_tasks') == 'on') ? 'yes' : 'no';
        $contract->contract_automation_project_email_client = (request('contract_automation_project_email_client') == 'on') ? 'yes' : 'no';
        $contract->contract_automation_create_invoice = (request('contract_automation_create_invoice') == 'on') ? 'yes' : 'no';
        $contract->contract_automation_invoice_due_date = request('contract_automation_invoice_due_date');
        $contract->contract_automation_invoice_email_client = (request('contract_automation_invoice_email_client') == 'on') ? 'yes' : 'no';
        $contract->save();

        //additional settings
        if (request('contract_automation_status') == 'disabled') {
            $contract->contract_automation_create_project = 'no';
            $contract->contract_automation_project_title = '';
            $contract->contract_automation_project_status = 'not_started';
            $contract->contract_automation_create_tasks = 'no';
            $contract->contract_automation_project_email_client = 'no';
            $contract->contract_automation_create_invoice = 'no';
            $contract->contract_automation_invoice_due_date = null;
            $contract->contract_automation_invoice_email_client = 'no';
            $contract->save();
        }

        //assigned users (reset)
        \App\Models\AutomationAssigned::Where('automationassigned_resource_type', 'contract')
            ->Where('automationassigned_resource_id', $id)
            ->delete();

        //assigned add (reset)
        if (request('contract_automation_status') == 'enabled' && is_array(request('contract_automation_assigned_users'))) {
            foreach (request('contract_automation_assigned_users') as $user_id) {
                $assigned = new \App\Models\AutomationAssigned();
                $assigned->automationassigned_resource_type = 'contract';
                $assigned->automationassigned_resource_id = $id;
                $assigned->automationassigned_userid = $user_id;
                $assigned->save();
            }
        }

        //get table friendly format
        $contracts = $this->contractrepo->search($contract->doc_id);
        $contract = $contracts->first();

        //reponse payload
        $payload = [
            'page' => $this->pageSettings('contracts'),
            'contract' => $contract,
            'contracts' => $contracts,
        ];

        //fire automation updated event
        event(new \App\Events\Contracts\ContractAutomationUpdated(request(), $id, $payload));

        //response
        return new UpdateAutomationResponse($payload);
    }

    /**
     * show the edit tags modal
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editTags($id) {

        //get the contract
        if (!$contract = \App\Models\Contract::Where('doc_id', $id)->first()) {
            abort(409, __('lang.contract_not_found'));
        }

        //get all tags for contracts
        $tags = $this->tagrepo->getByType('contract');

        //reponse payload
        $payload = [
            'tags' => $tags,
            'contract' => $contract,
            'response' => 'edit',
        ];

        //process reponse
        return new EditTagsResponse($payload);
    }

    /**
     * update the tags for a contract
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateTags($id) {

        //get the contract
        if (!$contract = \App\Models\Contract::Where('doc_id', $id)->first()) {
            abort(409, __('lang.contract_not_found'));
        }

        //delete & reapply tags
        $this->tagrepo->delete('contract', $id);
        $this->tagrepo->add('contract', $id);

        //get updated contract collection
        $contracts = $this->contractrepo->search($id);

        //get all tags
        $tags = $this->tagrepo->getByType('contract');

        //reponse payload
        $payload = [
            'tags' => $tags,
            'contracts' => $contracts,
            'id' => $id,
            'response' => 'update',
        ];

        //process reponse
        return new EditTagsResponse($payload);
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
            'crumbs' => [
                __('lang.contracts'),
            ],
            'crumbs_special_class' => 'list-pages-crumbs',
            'page' => 'contracts',
            'no_results_message' => __('lang.no_results_found'),
            'mainmenu_contracts' => 'active',
            'submenu_contracts' => 'active',
            'sidepanel_id' => 'sidepanel-filter-contracts',
            'dynamic_search_url' => url('contracts/search?action=search&contractresource_id=' . request('contractresource_id') . '&contractresource_type=' . request('contractresource_type')),
            'load_more_button_route' => 'contracts',
            'source' => 'list',
        ];

        //contracts list page
        if ($section == 'contracts') {

            //adjust
            $page['page'] = 'contract';

            $page += [
                'meta_title' => __('lang.contracts'),
                'heading' => __('lang.contracts'),
            ];

            return $page;
        }

        //contracts list page
        if ($section == 'contract') {

            //crumbs
            $page['crumbs'] = [
                __('lang.contract'),
                '#' . $data->formatted_id,
            ];

            $page += [
                'meta_title' => __('lang.contract'),
                'heading' => __('lang.contract'),
            ];
            if (request('source') == 'ext') {
                $page += [
                    'list_page_actions_size' => 'col-lg-12',
                ];
            }
            return $page;
        }

        //create new resource
        if ($section == 'create') {
            $page += [
                'section' => 'create',
            ];
            return $page;
        }

        //edit new resource
        if ($section == 'edit') {
            $page += [
                'section' => 'edit',
            ];
            return $page;
        }

        //return
        return $page;
    }
}
