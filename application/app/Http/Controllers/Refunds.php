<?php

/** --------------------------------------------------------------------------------
 * This controller manages all the business logic for refunds
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Refunds\RefundStoreUpdate;
use App\Http\Responses\Refunds\CreateResponse;
use App\Http\Responses\Refunds\DestroyResponse;
use App\Http\Responses\Refunds\EditResponse;
use App\Http\Responses\Refunds\IndexResponse;
use App\Http\Responses\Refunds\ShowResponse;
use App\Http\Responses\Refunds\StoreResponse;
use App\Http\Responses\Refunds\EditTagsResponse;
use App\Http\Responses\Refunds\UpdateResponse;
use App\Repositories\RefundRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;

class Refunds extends Controller {

    /**
     * The refund repository instance.
     */
    protected $refundrepo;

    /**
     * The tag repository instance.
     */
    protected $tagrepo;

    /**
     * Register middleware and inject the repository
     */
    public function __construct(RefundRepository $refundrepo, TagRepository $tagrepo) {

        //parent
        parent::__construct();

        //authenticated
        $this->middleware('auth');

        $this->middleware('refundsMiddlewareIndex')->only([
            'index',
            'store',
            'update',
            'updateTags',
        ]);

        $this->middleware('refundsMiddlewareCreate')->only([
            'create',
            'store',
        ]);

        $this->middleware('refundsMiddlewareEdit')->only([
            'edit',
            'update',
            'editTags',
            'updateTags',
        ]);

        $this->middleware('refundsMiddlewareDestroy')->only([
            'destroy',
        ]);

        $this->refundrepo = $refundrepo;
        $this->tagrepo = $tagrepo;
    }

    /**
     * Display a paginated listing of refunds
     * @return \Illuminate\Http\Response
     */
    public function index() {

        //get refunds
        $refunds = $this->refundrepo->search();

        //get tags
        $tags = $this->tagrepo->getByType('refund');

        //response payload
        $payload = [
            'page' => $this->pageSettings('refunds'),
            'refunds' => $refunds,
            'tags' => $tags,
        ];

        return new IndexResponse($payload);
    }

    /**
     * Show the form for creating a new refund
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $payment = [];

        //if a specific payment was requested, load and validate it
        if (request()->filled('refund_paymentid')) {

            if (!$payment = \App\Models\Payment::where('payment_id', request('refund_paymentid'))->first()) {
                abort(409, __('lang.error_loading_item'));
            }

            //enforce single-refund constraint
            if (\App\Models\Refund::where('refund_paymentid', $payment->payment_id)->exists()) {
                abort(409, __('lang.payment_already_refunded'));
            }
        }

        //response payload
        $payload = [
            'page' => $this->pageSettings('create'),
            'payment' => $payment,
        ];

        return new CreateResponse($payload);
    }

    /**
     * Store a newly created refund in storage
     * @param object RefundStoreUpdate validation request
     * @return \Illuminate\Http\Response
     */
    public function store(RefundStoreUpdate $request) {

        //load the linked payment
        if (!$payment = \App\Models\Payment::where('payment_id', request('refund_paymentid'))->first()) {
            abort(409, __('lang.error_loading_item'));
        }

        //enforce single-refund constraint
        if (\App\Models\Refund::where('refund_paymentid', $payment->payment_id)->exists()) {
            abort(409, __('lang.payment_already_refunded'));
        }

        //merge denormalized fields from the payment
        request()->merge([
            'refund_amount' => $payment->payment_amount,
            'refund_clientid' => $payment->payment_clientid,
            'refund_invoiceid' => $payment->payment_invoiceid,
            'refund_creatorid' => auth()->id(),
        ]);

        //create the refund
        $refund = new \App\Models\Refund();
        $refund->refund_uniqueid = str_unique();
        $refund->refund_paymentid = request('refund_paymentid');
        $refund->refund_clientid = request('refund_clientid');
        $refund->refund_invoiceid = request('refund_invoiceid');
        $refund->refund_creatorid = request('refund_creatorid');
        $refund->refund_amount = request('refund_amount');
        $refund->refund_date = request('refund_date');
        $refund->refund_notes = request('refund_notes');
        $refund->save();

        //add tags
        $this->tagrepo->add('refund', $refund->refund_id);

        //count all refunds (for first-row detection in the response)
        $count = \App\Models\Refund::count();

        //fetch the new row via the repository (with joins/eager loads)
        $refunds = $this->refundrepo->search($refund->refund_id);

        //response payload
        $payload = [
            'refunds' => $refunds,
            'count' => $count,
        ];

        return new StoreResponse($payload);
    }

    /**
     * Display the specified refund (receipt modal)
     * @param mixed $id refund uniqueid
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        //load refund with relationships
        if (!$refund = \App\Models\Refund::where('refund_uniqueid', $id)
            ->with(['payment', 'client'])->first()) {
            abort(409, __('lang.refund_not_found'));
        }

        //response payload
        $payload = [
            'refund' => $refund,
        ];

        return new ShowResponse($payload);
    }

    /**
     * Show the form for editing a refund
     * @param mixed $id refund uniqueid
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        //load the refund
        if (!$refund = \App\Models\Refund::where('refund_uniqueid', $id)->first()) {
            abort(409, __('lang.refund_not_found'));
        }

        //response payload
        $payload = [
            'page' => $this->pageSettings('edit'),
            'refund' => $refund,
        ];

        return new EditResponse($payload);
    }

    /**
     * Update a refund in storage (date and notes only)
     * @param object RefundStoreUpdate validation request
     * @param mixed $id refund uniqueid
     * @return \Illuminate\Http\Response
     */
    public function update(RefundStoreUpdate $request, $id) {

        //load the refund
        if (!$refund = \App\Models\Refund::where('refund_uniqueid', $id)->first()) {
            abort(409, __('lang.refund_not_found'));
        }

        //update editable fields
        $refund->refund_date = request('refund_date');
        $refund->refund_notes = request('refund_notes');
        $refund->save();

        //fetch the updated row via the repository
        $refunds = $this->refundrepo->search($refund->refund_id);

        //response payload
        $payload = [
            'refunds' => $refunds,
            'id' => $refund->refund_id,
        ];

        return new UpdateResponse($payload);
    }

    /**
     * Remove one or more refunds from storage
     * Processes bulk checkbox selections via request('ids')
     * @return \Illuminate\Http\Response
     */
    public function destroy() {

        $allrows = array();

        foreach (request('ids') as $id => $value) {
            //only checked items
            if ($value == 'on') {
                //load by auto-increment id
                if (!$refund = \App\Models\Refund::where('refund_id', $id)->first()) {
                    continue;
                }

                //mark original payment as 'paid'
                if ($payment = \App\Models\Payment::where('payment_id', $refund->refund_paymentid)->first()) {
                    $payment->payment_status = 'paid';
                    $payment->save();
                }

                $refund->delete();
                $allrows[] = $id;
            }
        }

        //response payload
        $payload = [
            'allrows' => $allrows,
        ];

        return new DestroyResponse($payload);
    }

    /**
     * Show the edit tags modal for a refund
     * @param int $id refund_id
     * @return \Illuminate\Http\Response
     */
    public function editTags($id) {

        //load the refund
        if (!$refund = \App\Models\Refund::where('refund_id', $id)->with(['tags'])->first()) {
            abort(409, __('lang.error_loading_item'));
        }

        //get all tags for this type
        $tags = $this->tagrepo->getByType('refund');

        //response payload
        $payload = [
            'refund' => $refund,
            'tags' => $tags,
            'response' => 'edit',
        ];

        return new EditTagsResponse($payload);
    }

    /**
     * Update tags for a refund
     * @param int $id refund_id
     * @return \Illuminate\Http\Response
     */
    public function updateTags($id) {

        //load the refund
        if (!$refund = \App\Models\Refund::where('refund_id', $id)->first()) {
            abort(409, __('lang.error_loading_item'));
        }

        //delete existing tags and add new ones
        $this->tagrepo->delete('refund', $refund->refund_id);
        $this->tagrepo->add('refund', $refund->refund_id);

        //get updated refunds row
        $refunds = $this->refundrepo->search($refund->refund_id);

        //get all tags
        $tags = $this->tagrepo->getByType('refund');

        //response payload
        $payload = [
            'refunds' => $refunds,
            'tags' => $tags,
            'id' => $refund->refund_id,
            'response' => 'update',
        ];

        return new EditTagsResponse($payload);
    }

    /**
     * Basic page settings for this section of the app
     * @param string $section page section (optional)
     * @param array $data additional data (optional)
     * @return array
     */
    private function pageSettings($section = '', $data = []) {

        $page = [
            'crumbs' =>
            [__('lang.billing'),
                __('lang.refunds'),
            ],
            'crumbs_special_class' => 'list-pages-crumbs',
            'heading' => __('lang.refunds'),
            'page' => 'refunds',
            'mainmenu_payments' => 'active',
            'mainmenu_sales' => 'active',
            'submenu_refunds' => 'active',
            'no_results_message' => __('lang.no_results_found'),
            'sidepanel_id' => 'sidepanel-filter-refunds',
            'dynamic_search_url' => url('refunds/search?action=search'),
            'load_more_button_route' => 'refunds',
            'source' => 'list',
        ];

        //default modal settings
        $page += [
            'add_modal_title' => __('lang.add_refund'),
            'add_modal_create_url' => url('refunds/create'),
            'add_modal_action_url' => url('refunds'),
            'add_modal_action_ajax_class' => 'ajax-request',
            'add_modal_action_ajax_loading_target' => 'commonModalBody',
            'add_modal_action_method' => 'POST',
        ];

        //additional page settings for modal sections
        $page += [
            'response' => $section,
        ];

        return $page;
    }
}
