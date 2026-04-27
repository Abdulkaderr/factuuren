<?php

/** --------------------------------------------------------------------------------
 * This model manages product custom fields
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCustomField extends Model {

    /**
     * @primaryKey string - primary key column
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */
    protected $table = 'items_custom_fields';
    protected $primaryKey = 'items_custom_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['items_custom_id'];
    const CREATED_AT = 'items_custom_field_created';
    const UPDATED_AT = 'items_custom_field_updated';
}
