<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model {

    /**
     * @primaryKey string - primary key column
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */
    protected $table = 'refunds';
    protected $primaryKey = 'refund_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['refund_id'];
    const CREATED_AT = 'refund_created';
    const UPDATED_AT = 'refund_updated';

    /**
     * relationship: a Refund belongs to one Payment
     */
    public function payment() {
        return $this->belongsTo('App\Models\Payment', 'refund_paymentid', 'payment_id')->withDefault();
    }

    /**
     * relationship: a Refund belongs to one Client
     */
    public function client() {
        return $this->belongsTo('App\Models\Client', 'refund_clientid', 'client_id')->withDefault();
    }

    /**
     * relationship: a Refund belongs to one User (creator)
     */
    public function creator() {
        return $this->belongsTo('App\Models\User', 'refund_creatorid', 'id')->withDefault();
    }

    /**
     * accessor: return formatted refund id (e.g. #000001)
     */
    public function getFormattedRefundIdAttribute() {
        return runtimeRefundIdFormat($this->refund_id);
    }

    /**
     * relatioship business rules:
     *         - the Refund can have many Tags
     *         - the Tag can belong to other tables
     */
    public function tags() {
        return $this->morphMany('App\Models\Tag', 'tagresource');
    }

}
