<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceStatus extends Model {

    /**
     * @primaryKey string - primry key column.
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */
    protected $table = 'invoice_statuses';
    protected $primaryKey = 'invoicestatus_id';
    protected $guarded = ['invoicestatus_id'];
    protected $dateFormat = 'Y-m-d H:i:s';
    const CREATED_AT = 'invoicestatus_created';
    const UPDATED_AT = 'invoicestatus_updated';

    /**
     * relatioship business rules:
     *         - the Invoice Status can have many Invoices
     *         - the Invoice belongs to one Invoice Status
     */
    public function invoices() {
        return $this->hasMany('App\Models\Invoice', 'bill_status', 'invoicestatus_id');
    }

}
