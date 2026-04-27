<?php

/** --------------------------------------------------------------------------------
 * This repository class manages shared billing operations for invoices and estimates
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use Illuminate\Http\Request;
use Log;

class BillingRepository {

    /**
     * Save line item discounts (inline mode only)
     * Works for both invoices and estimates
     *
     * @param string $bill_type - 'invoice' or 'estimate'
     * @param int $bill_id
     * @param array $line_ids
     * @return void
     */
    public function saveLineDiscounts($bill_type = 'invoice', $bill_id = '', $line_ids = []) {

        // Validation
        if (!in_array($bill_type, ['invoice', 'estimate']) || !is_numeric($bill_id) || !is_array($line_ids)) {
            return;
        }

        // Get bill (invoice or estimate)
        if ($bill_type == 'invoice') {
            $bill = \App\Models\Invoice::find($bill_id);
        } else {
            $bill = \App\Models\Estimate::find($bill_id);
        }

        if (!$bill) {
            return;
        }

        // Only process if in inline mode
        if ($bill->bill_tax_type != 'inline') {
            return;
        }

        // Process each line item
        foreach ($line_ids as $line_id) {

            if (!$lineitem = \App\Models\Lineitem::find($line_id)) {
                continue;
            }

            // Get discount data from request
            $discount_type = request("js_item_discount_type.{$line_id}", 'none');
            $discount_value = request("js_item_discount_value.{$line_id}", 0);

            // Calculate discount amount
            $discount_amount = 0;
            $line_subtotal = $lineitem->lineitem_quantity * $lineitem->lineitem_rate;

            if ($discount_type == 'fixed') {
                $discount_amount = floatval($discount_value);
            } elseif ($discount_type == 'percentage') {
                $discount_amount = ($line_subtotal * floatval($discount_value)) / 100;
            }

            // Ensure discount doesn't exceed subtotal
            if ($discount_amount > $line_subtotal) {
                $discount_amount = $line_subtotal;
            }

            // Update line item
            $lineitem->lineitem_discount_type = $discount_type;
            $lineitem->lineitem_discount_value = $discount_value;
            $lineitem->lineitem_discount_amount = $discount_amount;
            $lineitem->save();
        }
    }
}
