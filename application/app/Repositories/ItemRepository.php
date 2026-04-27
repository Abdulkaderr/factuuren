<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for product items
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Log;

class ItemRepository {

    /**
     * The items repository instance.
     */
    protected $items;

    /**
     * Inject dependecies
     */
    public function __construct(Item $items) {
        $this->items = $items;
    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @return object items collection
     */
    public function search($id = '') {

        $items = $this->items->newQuery();

        // all client fields
        $items->selectRaw('*');

        //joins
        $items->leftJoin('categories', 'categories.category_id', '=', 'items.item_categoryid');
        $items->leftJoin('pinned', function ($join) {
            $join->on('pinned.pinnedresource_id', '=', 'items.item_id')
                ->where('pinned.pinnedresource_type', '=', 'item');
            if (auth()->check()) {
                $join->where('pinned.pinned_userid', auth()->id());
            }
        });

        //eager load unit relationship for better performance
        $items->with('unit');

        //default where
        $items->whereRaw("1 = 1");

        //count items sold
        $items->selectRaw('(SELECT COUNT(DISTINCT l.lineitem_id)
                                FROM lineitems l
                                JOIN invoices i ON l.lineitemresource_id = i.bill_invoiceid
                                WHERE l.lineitem_linked_product_id = items.item_id
                                AND l.lineitemresource_type = "invoice"
                                AND i.bill_status = "paid") as count_sold');

        //sum items sold
        $items->selectRaw('(SELECT COALESCE(SUM(l.lineitem_total), 0)
                                FROM lineitems l
                                JOIN invoices i ON l.lineitemresource_id = i.bill_invoiceid
                                WHERE l.lineitem_linked_product_id = items.item_id
                                AND l.lineitemresource_type = "invoice"
                                AND i.bill_status = "paid") as sum_sold');
        //filters: id
        if (request()->filled('filter_item_id')) {
            $items->where('item_id', request('filter_item_id'));
        }
        if (is_numeric($id)) {
            $items->where('item_id', $id);
        }

        //filter: rate (min)
        if (request()->filled('filter_item_rate_min')) {
            $items->where('item_rate', '>=', request('filter_item_rate_min'));
        }

        //filter: rate (max)
        if (request()->filled('filter_item_rate_max')) {
            $items->where('item_rate', '>=', request('filter_item_rate_max'));
        }

        //filter category
        if (is_array(request('filter_item_categoryid')) && !empty(array_filter(request('filter_item_categoryid')))) {
            $items->whereIn('item_categoryid', request('filter_item_categoryid'));
        }

        //filter: description/notes
        if (request()->filled('filter_item_notes')) {
            $items->where('item_notes', 'LIKE', '%' . request('filter_item_notes') . '%');
        }

        //filter: tax status
        if (is_array(request('filter_item_tax_status')) && !empty(array_filter(request('filter_item_tax_status')))) {
            $items->whereIn('item_tax_status', request('filter_item_tax_status'));
        }

        //filter: default tax
        if (is_array(request('filter_item_default_tax')) && !empty(array_filter(request('filter_item_default_tax')))) {
            $items->whereIn('item_default_tax', request('filter_item_default_tax'));
        }

        //filter: custom field 1
        if (request()->filled('filter_item_custom_field_1')) {
            $items->where('item_custom_field_1', '=', request('filter_item_custom_field_1'));
        }

        //filter: custom field 2
        if (request()->filled('filter_item_custom_field_2')) {
            $items->where('item_custom_field_2', '=', request('filter_item_custom_field_2'));
        }

        //filter: custom field 3
        if (request()->filled('filter_item_custom_field_3')) {
            $items->where('item_custom_field_3', '=', request('filter_item_custom_field_3'));
        }

        //filter: custom field 4
        if (request()->filled('filter_item_custom_field_4')) {
            $items->where('item_custom_field_4', '=', request('filter_item_custom_field_4'));
        }

        //filter: custom field 5
        if (request()->filled('filter_item_custom_field_5')) {
            $items->where('item_custom_field_5', '=', request('filter_item_custom_field_5'));
        }

        //filter: custom field 6
        if (request()->filled('filter_item_custom_field_6')) {
            $items->where('item_custom_field_6', '=', request('filter_item_custom_field_6'));
        }

        //filter: custom field 7
        if (request()->filled('filter_item_custom_field_7')) {
            $items->where('item_custom_field_7', '=', request('filter_item_custom_field_7'));
        }

        //filter: custom field 8
        if (request()->filled('filter_item_custom_field_8')) {
            $items->where('item_custom_field_8', '=', request('filter_item_custom_field_8'));
        }

        //filter: custom field 9
        if (request()->filled('filter_item_custom_field_9')) {
            $items->where('item_custom_field_9', '=', request('filter_item_custom_field_9'));
        }

        //filter: custom field 10
        if (request()->filled('filter_item_custom_field_10')) {
            $items->where('item_custom_field_10', '=', request('filter_item_custom_field_10'));
        }

        //search: various columns and relationships (where first, then wherehas)
        if (request()->filled('search_query') || request()->filled('query')) {
            $items->where(function ($query) {
                $query->orWhere('item_description', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('item_rate', '=', request('search_query'));
                $query->orWhere('item_unit', '=', request('search_query'));
                $query->orWhere('item_notes', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('item_tax_status', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('item_custom_field_1', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('item_custom_field_2', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('item_custom_field_3', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('item_custom_field_4', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('item_custom_field_5', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('item_custom_field_6', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('item_custom_field_7', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('item_custom_field_8', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('item_custom_field_9', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('item_custom_field_10', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhereHas('category', function ($q) {
                    $q->where('category_name', 'LIKE', '%' . request('search_query') . '%');
                });
                $query->orWhereHas('defaultTaxRate', function ($q) {
                    $q->where('taxrate_name', 'LIKE', '%' . request('search_query') . '%');
                });
            });
        }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column name
            if (Schema::hasColumn('items', request('orderby'))) {
                $items->orderByRaw('CASE WHEN pinned.pinned_id IS NOT NULL THEN 1 ELSE 0 END DESC')
                    ->orderBy(request('orderby'), request('sortorder'));
            }
            //others
            switch (request('orderby')) {
            case 'category':
                $items->orderByRaw('CASE WHEN pinned.pinned_id IS NOT NULL THEN 1 ELSE 0 END DESC')
                    ->orderBy('category_name', request('sortorder'));
                break;
            case 'count_sold':
                $items->orderBy('count_sold', request('sortorder'));
                break;
            case 'sum_sold':
                $items->orderBy('sum_sold', request('sortorder'));
                break;
            }
        } else {
            //default sorting
            $items->orderByRaw('CASE WHEN pinned.pinned_id IS NOT NULL THEN 1 ELSE 0 END DESC')
                ->orderBy('item_id', 'desc');
        }

        //eager load
        $items->with(['category', 'defaultTaxRate']);

        // Get the results and return them.
        return $items->paginate(config('system.settings_system_pagination_limits'));
    }

    /**
     * Create a new record
     * @return mixed int|bool
     */
    public function create() {

        //save new user
        $item = new $this->items;

        //data
        $item->item_categoryid = request('item_categoryid');
        $item->item_creatorid = auth()->id();
        $item->item_description = request('item_description');
        $item->item_notes = request('item_notes');
        $item->item_unit = request('item_unit');
        $item->item_rate = request('item_rate');
        $item->item_notes_estimatation = request('item_notes_estimatation');
        $item->item_default_tax = request('item_default_tax');

        //save custom fields
        for ($i = 1; $i <= 10; $i++) {
            $field_name = 'item_custom_field_' . $i;
            if (request()->has($field_name)) {
                $item->$field_name = request($field_name);
            }
        }

        //save and return id
        if ($item->save()) {
            return $item->item_id;
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
        if (!$item = $this->items->find($id)) {
            return false;
        }

        //general
        $item->item_categoryid = request('item_categoryid');
        $item->item_description = request('item_description');
        $item->item_notes = request('item_notes');
        $item->item_unit = request('item_unit');
        $item->item_rate = request('item_rate');
        $item->item_notes_estimatation = request('item_notes_estimatation');
        $item->item_default_tax = request('item_default_tax');

        //update custom fields
        for ($i = 1; $i <= 10; $i++) {
            $field_name = 'item_custom_field_' . $i;
            if (request()->has($field_name)) {
                $item->$field_name = request($field_name);
            }
        }

        //save
        if ($item->save()) {
            return $item->item_id;
        } else {
            Log::error("unable to update record - database error", ['process' => '[ItemRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

}