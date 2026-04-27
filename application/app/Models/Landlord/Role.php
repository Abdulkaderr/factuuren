<?php

/** --------------------------------------------------------------------------------
 * Role model
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    /**
     * @primaryKey string - primary key column
     * @dateFormat string - date storage format
     * @guarded array - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['role_id'];
    const CREATED_AT = 'role_created';
    const UPDATED_AT = 'role_updated';

}
