<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
    'invoice' => 'App\Models\Invoice',
    'estimate' => 'App\Models\Estimate',
]);

class Lineitem extends Model {

    /**
     * @primaryKey string - primry key column.
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */
    protected $primaryKey = 'lineitem_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['lineitem_id'];
    const CREATED_AT = 'lineitem_created';
    const UPDATED_AT = 'lineitem_updated';

    /**
     * relatioship business rules:
     *   - estimates, invoices etc can have many lineitems
     *   - the lineitem can be belong to just one of the above
     *   - lineitems table columns named as [lineitemresource_type lineitemresource_id]
     */
    public function lineitemresource() {
        return $this->morphTo();
    }

    /**
     */
    public function taxes() {
        return $this->hasMany('App\Models\Tax', 'tax_lineitem_id', 'lineitem_id');
    }

    /**
     * mutator - trim whitespace from description
     */
    public function setLineitemDescriptionXAttribute($value) {
        $this->attributes['lineitem_description'] = trim($value);
    }

    /**
     * mutator - trim whitespace from long description
     */
    public function setLineitemLongDescriptionXAttribute($value) {
        $this->attributes['lineitem_long_description'] = $value ? trim($value) : null;
    }

    /**
     * relatioship business rules:
     *   - the lineitem can be linked to an item/product
     *   - the item can have many lineitems
     */
    public function item() {
        return $this->belongsTo('App\Models\Item', 'lineitem_linked_product_id', 'item_id')->withDefault();
    }

    /**
     * accessor - calculate tax amount for this line item
     * Calculation steps:
     *   1. Calculate subtotal based on line item type (plain, time, dimensions)
     *   2. Subtract discount to get after_discount amount
     *   3. Apply tax rates to the after_discount amount
     * Supports multiple taxes per line item
     */
    public function getLineitemTaxAmountAttribute() {
        $tax_amount = 0;

        // Step 1: Calculate subtotal based on line item type
        $subtotal = 0;
        $rate = $this->lineitem_rate ?? 0;

        if ($this->lineitem_type == 'plain') {
            // Plain items: rate × quantity
            $quantity = $this->lineitem_quantity ?? 0;
            $subtotal = $rate * $quantity;

        } elseif ($this->lineitem_type == 'time') {
            // Time items: (hours × rate) + (minutes/60 × rate)
            $hours = $this->lineitem_time_hours ?? 0;
            $minutes = $this->lineitem_time_minutes ?? 0;
            $hours_total = $hours * $rate;
            $minutes_total = 0;
            if ($minutes > 0) {
                $minutes_total = ($minutes / 60) * $rate;
            }
            $subtotal = $hours_total + $minutes_total;

        } elseif ($this->lineitem_type == 'dimensions') {
            // Dimensions items: (length × width) × rate × quantity
            $length = $this->lineitem_dimensions_length ?? 0;
            $width = $this->lineitem_dimensions_width ?? 0;
            $quantity = $this->lineitem_quantity ?? 0;
            $area = $length * $width;
            $subtotal = $area * $rate * $quantity;
        }

        // Step 2: Apply discount to get after_discount amount
        $discount_amount = $this->lineitem_discount_amount ?? 0;
        $after_discount = $subtotal - $discount_amount;

        // Step 3: Calculate tax on after_discount amount
        if ($this->relationLoaded('taxes') && $this->taxes) {
            foreach ($this->taxes as $tax) {
                if (isset($tax->tax_rate) && $tax->tax_rate > 0) {
                    $tax_amount += ($after_discount * $tax->tax_rate) / 100;
                }
            }
        }

        return $tax_amount;
    }

    /**
     * accessor - calculate net line total for this line item
     * Net total is quantity × rate with no tax or discount applied
     * Calculation varies by line item type:
     *   - Plain items: rate × quantity
     *   - Time items: (hours × rate) + (minutes/60 × rate)
     *   - Dimensions items: (length × width) × rate × quantity
     */
    public function getNetLineTotalAttribute() {
        $net_total = 0;
        $rate = $this->lineitem_rate ?? 0;

        if ($this->lineitem_type == 'plain') {
            // Plain items: rate × quantity
            $quantity = $this->lineitem_quantity ?? 0;
            $net_total = $rate * $quantity;

        } elseif ($this->lineitem_type == 'time') {
            // Time items: (hours × rate) + (minutes/60 × rate)
            $hours = $this->lineitem_time_hours ?? 0;
            $minutes = $this->lineitem_time_minutes ?? 0;
            $hours_total = $hours * $rate;
            $minutes_total = 0;
            if ($minutes > 0) {
                $minutes_total = ($minutes / 60) * $rate;
            }
            $net_total = $hours_total + $minutes_total;

        } elseif ($this->lineitem_type == 'dimensions') {
            // Dimensions items: (length × width) × rate × quantity
            $length = $this->lineitem_dimensions_length ?? 0;
            $width = $this->lineitem_dimensions_width ?? 0;
            $quantity = $this->lineitem_quantity ?? 0;
            $area = $length * $width;
            $net_total = $area * $rate * $quantity;
        }

        return $net_total;
    }

}
