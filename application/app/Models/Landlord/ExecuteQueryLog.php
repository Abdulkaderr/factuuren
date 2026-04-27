<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Model;

class ExecuteQueryLog extends Model {

    /**
     * @primaryKey string - primary key column
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */

    protected $connection = 'landlord';
    protected $table = 'execute_queries_logs';
    protected $primaryKey = 'execute_queries_log_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['execute_queries_log_id'];
    const CREATED_AT = 'execute_queries_log_created';
    const UPDATED_AT = 'execute_queries_log_updated';

    /**
     * Relationship to execute query
     */
    public function executeQuery() {
        return $this->belongsTo('App\Models\Landlord\ExecuteQuery', 'execute_queries_log_query_uniqueid', 'execute_query_uniqueid')->withDefault();
    }
}
