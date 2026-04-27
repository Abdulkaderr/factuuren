<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data abstraction for refunds
 *
 * NOTE: create(), update(), and delete() belong in the controller — not here
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Log;

class RefundRepository {

    /**
     * The refund repository instance.
     */
    protected $refunds;

    /**
     * Inject dependencies
     */
    public function __construct(Refund $refunds) {
        $this->refunds = $refunds;
    }

    /**
     * Search model
     * @param int $id optional — fetch a single record by refund_id
     * @param array $data optional data payload
     * @return object refunds collection (paginated)
     */
    public function search($id = '', $data = array()) {

        $refunds = $this->refunds->newQuery();

        //all fields
        $refunds->selectRaw('refunds.*, clients.client_company_name, users.first_name, users.last_name, users.avatar_directory as creator_avatar_directory, users.avatar_filename as creator_avatar_filename');

        //joins
        $refunds->leftJoin('clients', 'clients.client_id', '=', 'refunds.refund_clientid');
        $refunds->leftJoin('payments', 'payments.payment_id', '=', 'refunds.refund_paymentid');
        $refunds->leftJoin('invoices', 'invoices.bill_invoiceid', '=', 'refunds.refund_invoiceid');
        $refunds->leftJoin('users', 'users.id', '=', 'refunds.refund_creatorid');

        //default where
        $refunds->whereRaw("1 = 1");

        //filter by numeric id (single record fetch)
        if (is_numeric($id)) {
            $refunds->where('refund_id', $id);
        }

        //filter: refund date (start)
        if (request()->filled('filter_refund_date_start')) {
            $refunds->whereDate('refund_date', '>=', request('filter_refund_date_start'));
        }

        //filter: refund date (end)
        if (request()->filled('filter_refund_date_end')) {
            $refunds->whereDate('refund_date', '<=', request('filter_refund_date_end'));
        }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column on refunds table
            if (Schema::hasColumn('refunds', request('orderby'))) {
                $refunds->orderBy(request('orderby'), request('sortorder'));
            }
            //special cases (joined columns)
            switch (request('orderby')) {
            case 'client':
                $refunds->orderBy('client_company_name', request('sortorder'));
                break;
            case 'first_name':
                $refunds->orderBy('first_name', request('sortorder'));
                break;
            }
        } else {
            //default sort
            $refunds->orderBy('refund_id', 'desc');
        }

        //filter: tags
        if (is_array(request('filter_tags')) && !empty(request('filter_tags'))) {
            $refunds->whereHas('tags', function ($q) {
                $q->whereIn('tag_title', request('filter_tags'));
            });
        }

        //search: keyword
        if (request()->filled('search_query') || request()->filled('query')) {
            $search = request('search_query') ?? request('query');
            $refunds->where(function ($q) use ($search) {
                $q->orWhere('refund_notes', 'LIKE', '%' . $search . '%');
                $q->orWhereHas('tags', function ($q) use ($search) {
                    $q->where('tag_title', 'LIKE', '%' . $search . '%');
                });
            });
        }

        //eager load
        $refunds->with(['payment', 'client', 'tags']);

        return $refunds->paginate(config('system.settings_system_pagination_limits'));
    }

}
