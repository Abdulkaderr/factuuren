<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for invoice statuses
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\InvoiceStatus;
use Log;

class InvoiceStatusRepository {

    /**
     * The invoice status repository instance.
     */
    protected $status;

    /**
     * Inject dependecies
     */
    public function __construct(InvoiceStatus $status) {
        $this->status = $status;
    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @return object invoice status collection
     */
    public function search($id = '') {

        $status = $this->status->newQuery();

        //joins
        $status->leftJoin('users', 'users.id', '=', 'invoice_statuses.invoicestatus_creatorid');

        // all client fields
        $status->selectRaw('*');

        //count invoices
        $status->selectRaw('(SELECT COUNT(*)
                                      FROM invoices
                                      WHERE bill_status = invoice_statuses.invoicestatus_id)
                                      AS count_invoices');
        if (is_numeric($id)) {
            $status->where('invoicestatus_id', $id);
        }

        //default sorting
        $status->orderBy('invoicestatus_position', 'asc');

        // Get the results and return them.
        return $status->paginate(10000);
    }

    /**
     * update a record
     * @param int $id record id
     * @return mixed bool or id of record
     */
    public function update($id) {

        //get the record
        if (!$status = $this->status->find($id)) {
            return false;
        }

        //general
        $status->invoicestatus_title = preg_replace('%[\[\'"\/\?\\\{}\]]%', '', request('invoicestatus_title'));
        $status->invoicestatus_color = request('invoicestatus_color');

        //save
        if ($status->save()) {
            return $status->invoicestatus_id;
        } else {
            Log::error("record could not be updated - database error", ['process' => '[InvoiceStatusRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * Create a new record
     * @param int $position position of new record
     * @return mixed object|bool
     */
    public function create($position = '') {

        //validate
        if (!is_numeric($position)) {
            Log::error("error creating a new invoice status record in DB - (position) value is invalid", ['process' => '[create()]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

        //save
        $status = new $this->status;

        //data
        $status->invoicestatus_title = preg_replace('%[\[\'"\/\?\\\{}\]]%', '', request('invoicestatus_title'));
        $status->invoicestatus_color = request('invoicestatus_color');
        $status->invoicestatus_creatorid = auth()->id();
        $status->invoicestatus_position = $position;

        //save and return id
        if ($status->save()) {
            return $status->invoicestatus_id;
        } else {
            Log::error("record could not be updated - database error", ['process' => '[InvoiceStatusRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }


}
