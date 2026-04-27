<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Model;

class ExecuteQuery extends Model {

    /**
     * @primaryKey string - primary key column
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */

    protected $connection = 'landlord';
    protected $table = 'execute_queries';
    protected $primaryKey = 'execute_query_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['execute_query_id'];
    const CREATED_AT = 'execute_query_created';
    const UPDATED_AT = 'execute_query_updated';

    /**
     * Relationship to creator user
     */
    public function creator() {
        return $this->belongsTo('App\Models\User', 'execute_query_creatorid', 'id')->withDefault();
    }

    /**
     * Relationship to execution logs
     */
    public function logs() {
        return $this->hasMany('App\Models\Landlord\ExecuteQueryLog', 'execute_queries_log_query_uniqueid', 'execute_query_uniqueid');
    }
}
