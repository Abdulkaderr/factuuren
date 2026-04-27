<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Model;

class Log extends Model {

    /**
     * @primaryKey string - primry key column.
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */

    protected $table = 'logs';
    protected $connection = 'landlord';
    protected $primaryKey = 'log_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['log_id'];
    const CREATED_AT = 'log_created';
    const UPDATED_AT = 'log_updated';

}
