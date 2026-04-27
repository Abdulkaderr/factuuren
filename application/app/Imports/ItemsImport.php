<?php

/** --------------------------------------------------------------------------------
 * This class handles importing items from Excel files
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Imports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ItemsImport implements ToModel, WithStartRow, WithHeadingRow, WithValidation, SkipsOnFailure {

    use Importable, SkipsFailures;

    private $rows = 0;
    private $skipped = 0;

    /**
     * Process each row from the Excel file and create an item
     * Excel headers are human-readable ("Product Name", "Tax Rate")
     * Laravel Excel converts them to array keys ($row['product_name'], $row['tax_rate'])
     * @param array $row - Excel row data
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row) {

        // Check for duplicates before creating the item (only if skip_duplicates is enabled)
        if (request('skip_duplicates') == 'on') {
            if ($this->isDuplicate($row)) {
                $this->skipped++;
                return null;
            }
        }

        ++$this->rows;

        // Process category (ID or name)
        // Excel header "Category" becomes $row['category']
        $category_id = 8; // default item category
        if (!empty($row['category'])) {
            if (is_numeric($row['category'])) {
                // If numeric, use as category ID directly
                $category_id = $row['category'];
            } else {
                // If string, search for category by name (case-insensitive)
                $category = \App\Models\Category::where('category_type', 'item')
                    ->whereRaw('LOWER(category_name) = ?', [strtolower($row['category'])])->first();
                $category_id = $category ? $category->category_id : 8;
            }
        }

        // Process tax rate (ID or name)
        // Excel header "Tax Rate" becomes $row['tax_rate']
        $tax_rate_id = 5; // default (0% tax)
        if (!empty($row['tax_rate'])) {
            if (is_numeric($row['tax_rate'])) {
                // If numeric, use as tax rate ID directly
                $tax_rate_id = $row['tax_rate'];
            } else {
                // If string, search for tax rate by name (case-insensitive)
                $taxRate = \App\Models\TaxRate::whereRaw('LOWER(taxrate_name) = ?', [strtolower($row['tax_rate'])])->first();
                $tax_rate_id = $taxRate ? $taxRate->taxrate_id : 5;
            }
        }

        // Process unit (ID or name)
        // Excel header "Unit" becomes $row['unit']
        // item_unit is numeric and maps to unit_id from units table
        $unit_id = null;
        $unit_input = $row['unit'] ?? 'Item';

        if (!empty($unit_input)) {
            if (is_numeric($unit_input)) {
                // If numeric, use as unit ID directly
                $unit_id = $unit_input;
            } else {
                // If string, search for unit by name (case-insensitive)
                $existing_unit = \App\Models\Unit::whereRaw('LOWER(unit_name) = ?', [strtolower($unit_input)])->first();

                if ($existing_unit) {
                    // Use existing unit ID
                    $unit_id = $existing_unit->unit_id;
                } else {
                    // Create new unit and get its ID
                    $new_unit = new \App\Models\Unit();
                    $new_unit->unit_name = $unit_input;
                    $new_unit->unit_creatorid = auth()->id();
                    $new_unit->save();
                    $unit_id = $new_unit->unit_id;
                }
            }
        }

        // Prepare item data
        // Excel headers map to database columns:
        // "Product Name" -> $row['product_name'] -> item_description
        // "Description" -> $row['description'] -> item_notes
        // "Unit" -> $row['unit'] -> item_unit (numeric unit_id)
        // "Rate" -> $row['rate'] -> item_rate
        $item_data = [
            'item_description' => $row['product_name'] ?? '',
            'item_notes' => $row['description'] ?? '',
            'item_unit' => $unit_id,
            'item_rate' => $row['rate'] ?? 0,
            'item_categoryid' => $category_id,
            'item_default_tax' => $tax_rate_id,
            'item_tax_status' => 'taxable',
            'item_type' => 'standard',
            'item_creatorid' => auth()->id(),
        ];

        // Add item_importid if column exists in items table
        if (\Illuminate\Support\Facades\Schema::hasColumn('items', 'item_importid')) {
            $item_data['item_importid'] = request('import_ref');
        }

        // Add inventory fields if module is installed
        // Excel headers: "Track Inventory" -> $row['track_inventory'], "Low Stock Level" -> $row['low_stock_level']
        if (\Illuminate\Support\Facades\Schema::hasColumn('items', 'mod_purchasing_stock_tracking_enabled')) {
            // Convert "yes", "y", "1" to "yes", everything else to "no"
            $track_inventory = strtolower($row['track_inventory'] ?? 'no');
            $tracking_enabled = in_array($track_inventory, ['yes', 'y', '1']) ? 'yes' : 'no';
            $item_data['mod_purchasing_stock_tracking_enabled'] = $tracking_enabled;

            // Only set low stock level if tracking is enabled AND the column exists
            if ($tracking_enabled === 'yes' && \Illuminate\Support\Facades\Schema::hasColumn('items', 'mod_purchasing_minimum_stock_level')) {
                $item_data['mod_purchasing_minimum_stock_level'] = $row['low_stock_level'] ?? 0;
            }
        }

        return new \App\Models\Item($item_data);
    }

    /**
     * Check if the item is a duplicate based on product name, unit, and rate
     * Excel headers: "Product Name" -> $row['product_name'], "Unit" -> $row['unit'], "Rate" -> $row['rate']
     * @param array $row
     * @return bool
     */
    protected function isDuplicate($row) {

        $duplicate_found = false;

        // All three fields must be present to check for duplicates
        if (!empty($row['product_name']) && !empty($row['unit']) && isset($row['rate'])) {

            // Convert unit to unit_id (same logic as in model() method)
            $unit_id = null;
            $unit_input = $row['unit'];

            if (is_numeric($unit_input)) {
                // If numeric, use as unit ID directly
                $unit_id = $unit_input;
            } else {
                // If string, search for unit by name (case-insensitive)
                $existing_unit = \App\Models\Unit::whereRaw('LOWER(unit_name) = ?', [strtolower($unit_input)])->first();
                if ($existing_unit) {
                    $unit_id = $existing_unit->unit_id;
                }
                // If unit doesn't exist, it will be created in model(), so no match possible
            }

            // Only check for duplicate if we found/have a valid unit_id
            if ($unit_id !== null) {
                // Check by product name, unit, and rate
                $duplicate_found = \App\Models\Item::whereRaw('LOWER(item_description) = ?', [strtolower($row['product_name'])])
                    ->where('item_unit', $unit_id)
                    ->where('item_rate', $row['rate'])
                    ->exists();
            }
        }

        return $duplicate_found;
    }

    /**
     * Define validation rules for import
     * Excel headers converted to array keys by Laravel Excel:
     * "Product Name" -> 'product_name'
     * "Rate" -> 'rate'
     * "Unit" -> 'unit'
     * @return array
     */
    public function rules(): array
    {
        return [
            'product_name' => ['required'],
            'rate' => ['required', 'numeric'],
            'unit' => ['required'],
        ];
    }

    /**
     * We are ignoring the header and so we will start with row number (2)
     * @return int
     */
    public function startRow(): int {
        return 2;
    }

    /**
     * Get count of total imported rows
     * @return int
     */
    public function getRowCount(): int {
        return $this->rows;
    }

    /**
     * Get count of skipped duplicate rows
     * @return int
     */
    public function getSkippedCount(): int {
        return $this->skipped;
    }
}
