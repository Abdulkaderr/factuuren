<?php

/** --------------------------------------------------------------------------------
 * TableConfig model — landlord side
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Model;

class TableConfig extends Model {

    /**
     * @primaryKey  string - primary key column
     * @guarded     array  - prevent mass assignment on primary key
     * @CREATED_AT  string - created timestamp column name
     * @UPDATED_AT  string - updated timestamp column name
     */
    protected $table = 'tableconfig';
    protected $primaryKey = 'tableconfig_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['tableconfig_id'];
    const CREATED_AT = 'tableconfig_created';
    const UPDATED_AT = 'tableconfig_updated';

}
