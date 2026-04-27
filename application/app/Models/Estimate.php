<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estimate extends Model {

    /**
     * @primaryKey string - primry key column.
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */
    protected $primaryKey = 'bill_estimateid';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['bill_estimateid'];
    const CREATED_AT = 'bill_created';
    const UPDATED_AT = 'bill_updated';

    /**
     * relatioship business rules:
     *         - the Creator (user) can have many Estimates
     *         - the Estimate belongs to one Creator (user)
     */
    public function creator() {
        return $this->belongsTo('App\Models\User', 'bill_creatorid', 'id');
    }

    /**
     * relatioship business rules:
     *         - the Category can have many Estimates
     *         - the Estimate belongs to one Category
     */
    public function category() {
        return $this->belongsTo('App\Models\Category', 'bill_categoryid', 'category_id');
    }

    /**
     * relatioship business rules:
     *         - the Estimate belongs to one Client
     */
    public function client() {
        return $this->belongsTo('App\Models\Client', 'bill_clientid', 'client_id');
    }

    /**
     * relatioship business rules:
     *         - the Estimate belongs to one Project
     */
    public function project() {
        return $this->belongsTo('App\Models\Project', 'estimate_projectid', 'project_id');
    }

    /**
     * relatioship business rules:
     *         - the Estimate can have many Lineitems
     *         - the Lineitem belongs to one Estimate
     *         - other Lineitems can belong to other tables
     */
    public function lineitems() {
        return $this->morphMany('App\Models\Lineitem', 'lineitemresource');
    }

    /**
     * relatioship business rules:
     *         - the Estimate can have many Tags
     *         - the Tags belongs to one Estimate
     *         - other tags can belong to other tables
     */
    public function tags() {
        return $this->morphMany('App\Models\Tag', 'tagresource');
    }

    /**
     */
    public function taxes() {
        return $this->morphMany('App\Models\Tax', 'taxresource');
    }

    /**
     * display format for estimate id - adding leading zeros & with any set prefix
     * e.g. INV-000001
     */
    public function getFormattedBillEstimateidAttribute() {
        return runtimeEstimateIdFormat($this->bill_estimateid);
    }

    /**
     * pre-formatted data
     * @return string
     */
    public function getFormattedBillDateAttribute() {
        return runtimeDate($this->bill_date);
    }

    /**
     * pre-formatted data
     * @return string
     */
    public function getFormattedBillExpiryDateAttribute() {
        return runtimeDate($this->bill_expiry_date);
    }

    /**
     * relatioship business rules:
     *         - the Estimate can have many Starred entries
     *         - the Starred entry belongs to one Estimate
     *         - other Starred entries can belong to other resources
     */
    public function starred() {
        return $this->morphMany('App\Models\Starred', 'starredresource', 'starred_resource_type', 'starred_resource_id');
    }

    /**
     * check if the estimate is starred by the current user
     * @return bool
     */
    public function getIsStarredAttribute() {
        if (!auth()->check()) {
            return false;
        }

        return \App\Models\Starred::where('starred_userid', auth()->id())
            ->where('starred_resource_type', 'estimate')
            ->where('starred_resource_id', $this->bill_estimateid)
            ->exists();
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
