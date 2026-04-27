<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

    /**
     * @primaryKey string - primry key column.
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */
    protected $primaryKey = 'item_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['item_id'];
    const CREATED_AT = 'item_created';
    const UPDATED_AT = 'item_updated';

    /**
     * relatioship business rules:
     *         - the Creator (user) can have many Items
     *         - the Item belongs to one Creator (user)
     */
    public function creator() {
        return $this->belongsTo('App\Models\User', 'item_creatorid', 'id');
    }

    /**
     * relatioship business rules:
     *         - the Category can have many Invoices
     *         - the Invoice belongs to one Category
     */
    public function category() {
        return $this->belongsTo('App\Models\Category', 'item_categoryid', 'category_id');
    }

    /**
     * relatioship business rules:
     *         - the TaxRate can have many Items
     *         - the Item belongs to one TaxRate
     */
    public function defaultTaxRate() {
        return $this->belongsTo('App\Models\TaxRate', 'item_default_tax', 'taxrate_id')->withDefault();
    }

    /**
     * relatioship business rules:
     *         - the Unit can have many Items
     *         - the Item belongs to one Unit
     */
    public function unit() {
        return $this->belongsTo('App\Models\Unit', 'item_unit', 'unit_id')->withDefault();
    }

    /**
     * Estimates notes formatted in json
     * @return string
     */
    public function getEstimationNotesEncodedAttribute() {
        return htmlentities($this->item_notes_estimatation);
    }

    /**
     * Estimates notes check
     * @return string
     */
    public function getHasEstimationNotesAttribute() {
        return ($this->item_notes_estimatation != '') ? 'yes' : 'no';
    }

    /**
     * Check if item has any enabled custom fields with values
     * that should be displayed on invoices
     * @return bool
     */
    public function getHasEnabledCustomFieldsAttribute() {
        return !empty($this->enabled_custom_fields);
    }

/**
 * Get all enabled custom fields that have values and should show on invoices
 * Returns array of ['name' => 'Field Name', 'value' => 'Field Value']
 * @return array
 */
    public function getEnabledCustomFieldsAttribute() {
        
        // Cache the custom fields query to avoid repeated database calls
        static $customFieldsCache = null;

        if ($customFieldsCache === null) {
            $customFieldsCache = \App\Models\ProductCustomField::where('items_custom_field_status', 'enabled')
                ->where('items_custom_field_show_on_invoice', 'yes')
                ->get()
                ->keyBy('items_custom_id');
        }

        $result = [];

        // Loop through all 10 custom field columns
        for ($i = 1; $i <= 10; $i++) {
            $fieldColumn = 'item_custom_field_' . $i;
            $fieldValue = $this->{$fieldColumn};

            // Skip if no value or empty string
            if (empty($fieldValue)) {
                continue;
            }

            // Check if this custom field is enabled and should show on invoice
            if (isset($customFieldsCache[$i])) {
                $customField = $customFieldsCache[$i];

                $result[] = [
                    'name' => $customField->items_custom_field_name,
                    'value' => $fieldValue,
                ];
            }
        }

        return $result;
    }

}
