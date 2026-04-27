<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {

    /**
     * @primaryKey string - primry key column.
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */
    protected $primaryKey = 'bill_invoiceid';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['bill_invoiceid'];
    const CREATED_AT = 'bill_created';
    const UPDATED_AT = 'bill_updated';

    /**
     * relatioship business rules:
     *         - the Creator (user) can have many Invoices
     *         - the Invoice belongs to one Creator (user)
     */
    public function creator() {
        return $this->belongsTo('App\Models\User', 'bill_creatorid', 'id');
    }

    /**
     * relatioship business rules:
     *         - the Invoice belongs to one Client
     */
    public function client() {
        return $this->belongsTo('App\Models\Client', 'bill_clientid', 'client_id');
    }

    /**
     * relatioship business rules:
     *         - the Invoice belongs to one Project
     */
    public function project() {
        return $this->belongsTo('App\Models\Project', 'bill_projectid', 'project_id');
    }

    /**
     * relatioship business rules:
     *         - the Category can have many Invoices
     *         - the Invoice belongs to one Category
     */
    public function category() {
        return $this->belongsTo('App\Models\Category', 'bill_categoryid', 'category_id');
    }

    /**
     * relatioship business rules:
     *         - the Invoice Status can have many Invoices
     *         - the Invoice belongs to one Invoice Status
     */
    public function status() {
        return $this->belongsTo('App\Models\InvoiceStatus', 'bill_status', 'invoicestatus_id')->withDefault();
    }

    /**
     * relatioship business rules:
     *         - the Invoice can have many Lineitems
     *         - the Lineitem belongs to one Invoice
     *         - other Lineitems can belong to other tables
     */
    public function lineitems() {
        return $this->morphMany('App\Models\Lineitem', 'lineitemresource');
    }

    /**
     * relatioship business rules:
     *         - the Invoice can have many Payments
     *         - the Payment belongs to one Invoice
     */
    public function payments() {
        return $this->hasMany('App\Models\Payment', 'payment_invoiceid', 'bill_invoiceid');
    }

    /**
     * relatioship business rules:
     *         - the Invoice can have many Tags
     *         - the Tags belongs to one Invoice
     *         - other tags can belong to other tables
     */
    public function tags() {
        return $this->morphMany('App\Models\Tag', 'tagresource');
    }

    /**
     * display format for invoice id - adding leading zeros & with any set prefix
     * formatted_bill_invoiceid
     * e.g. INV-000001
     */
    public function getFormattedBillInvoiceidAttribute() {
        return runtimeInvoiceIdFormat($this->bill_invoiceid);
    }

    /**
     */
    public function taxes() {
        return $this->morphMany('App\Models\Tax', 'taxresource');
    }

    /**
     * relatioship business rules:
     *         - the Invoice can have many Starred entries
     *         - the Starred entry belongs to one Invoice
     *         - other Starred entries can belong to other resources
     */
    public function starred() {
        return $this->morphMany('App\Models\Starred', 'starredresource', 'starred_resource_type', 'starred_resource_id');
    }

    /**
     * check if the invoice is starred by the current user
     * @return bool
     */
    public function getIsStarredAttribute() {
        if (!auth()->check()) {
            return false;
        }

        return \App\Models\Starred::where('starred_userid', auth()->id())
            ->where('starred_resource_type', 'invoice')
            ->where('starred_resource_id', $this->bill_invoiceid)
            ->exists();
    }

    /**
     * relationship: the user who cancelled this invoice
     */
    public function cancelledBy() {
        return $this->belongsTo('App\Models\User', 'bill_cancellation_userid', 'id')->withDefault();
    }

    /**
     * accessor - calculate subtotal after discount
     * In inline tax mode: bill_subtotal contains the final total (including tax)
     * So we calculate: subtotal_before_discount - discount_amount
     * In summary tax mode: bill_subtotal already represents after-discount amount
     */
    public function getBillSubtotalAfterDiscountAttribute() {
        if ($this->bill_tax_type == 'inline') {
            $before_discount = $this->bill_subtotal_before_discount ?? 0;
            $discount = $this->bill_discount_amount ?? 0;
            return $before_discount - $discount;
        }
        // For summary mode, bill_subtotal is already the after-discount amount
        return $this->bill_subtotal ?? 0;
    }

}
