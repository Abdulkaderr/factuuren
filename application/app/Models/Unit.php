<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model {

    /**
     * @primaryKey string - primry key column.
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */
    protected $table = 'units';
    protected $primaryKey = 'unit_id';
    protected $guarded = ['unit_id'];
    protected $dateFormat = 'Y-m-d H:i:s';
    const CREATED_AT = 'unit_created';
    const UPDATED_AT = 'unit_update';

    /**
     * relatioship business rules:
     *         - the Unit can have many Items
     *         - the Item belongs to one Unit
     */
    public function items() {
        return $this->hasMany('App\Models\Item', 'item_unit', 'unit_id');
    }

    /**
     * Accessor: Count items using this unit
     */
    public function getItemsCountAttribute() {
        return $this->items()->count();
    }
}
