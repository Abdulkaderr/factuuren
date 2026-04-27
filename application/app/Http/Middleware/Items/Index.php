<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [index] precheck processes for product items
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Items;

use App\Models\Item;
use Closure;
use Log;

class Index {

    /**
     * This middleware does the following
     *   2. checks users permissions to [view] items
     *   3. modifies the request object as needed
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //table config
        $this->tableConfig();

        //various frontend and visibility settings
        $this->fronteEnd();

        //admin user permission
        if (auth()->user()->is_team) {
            if (auth()->user()->role->role_items >= 1) {

                return $next($request);
            }
        }

        //permission denied
        Log::error("permission denied", ['process' => '[permissions][items][index]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }

    /**
     * Set the users table column visibility preferences
     *
     * @tablename - items
     */
    private function tableConfig() {

        //get current settings or create for user
        if (!$table = \App\Models\TableConfig::Where('tableconfig_userid', auth()->id())->Where('tableconfig_table_name', 'items')->first()) {

            //create for this user and set the visible columns
            $table = new \App\Models\TableConfig();
            $table->tableconfig_userid = auth()->id();
            $table->tableconfig_table_name = 'items';

            //Default taable layout
            $table->tableconfig_column_1 = 'displayed'; //title
            $table->tableconfig_column_2 = 'displayed'; //rate
            $table->tableconfig_column_3 = 'displayed'; //unit
            $table->tableconfig_column_4 = 'displayed'; //category
            $table->tableconfig_column_5 = 'displayed'; //number sold
            $table->tableconfig_column_6 = 'displayed'; //amount sold

            //Additional table columns (hidden by default)
            $table->tableconfig_column_7 = 'hidden'; //description
            $table->tableconfig_column_8 = 'hidden'; //tax status
            $table->tableconfig_column_9 = 'hidden'; //default tax
            $table->tableconfig_column_10 = 'hidden'; //custom field 1
            $table->tableconfig_column_11 = 'hidden'; //custom field 2
            $table->tableconfig_column_12 = 'hidden'; //custom field 3
            $table->tableconfig_column_13 = 'hidden'; //custom field 4
            $table->tableconfig_column_14 = 'hidden'; //custom field 5
            $table->tableconfig_column_15 = 'hidden'; //custom field 6
            $table->tableconfig_column_16 = 'hidden'; //custom field 7
            $table->tableconfig_column_17 = 'hidden'; //custom field 8
            $table->tableconfig_column_18 = 'hidden'; //custom field 9
            $table->tableconfig_column_19 = 'hidden'; //custom field 10
            $table->save();
        }

        //synchronize disabled custom fields
        $this->syncCustomFieldPreferences($table);

        //get row
        $table = \App\Models\TableConfig::Where('tableconfig_userid', auth()->id())->Where('tableconfig_table_name', 'items')->first();

        //load table config into config
        config(['table' => $table]);

    }

    /**
     * Synchronize user's custom field preferences with enabled status
     * Remove disabled custom fields from user's table config
     */
    private function syncCustomFieldPreferences($table) {

        //get all custom fields
        $customFields = \App\Models\ProductCustomField::all();

        $needsUpdate = false;

        foreach ($customFields as $customField) {
            //map custom field ID to tableconfig column
            $columnNumber = 9 + $customField->items_custom_id;
            $columnName = 'tableconfig_column_' . $columnNumber;

            //if custom field is disabled but user has it visible, hide it
            if ($customField->items_custom_field_status != 'enabled' &&
                $table->$columnName == 'displayed') {
                $table->$columnName = 'hidden';
                $needsUpdate = true;
            }
        }

        if ($needsUpdate) {
            $table->save();
        }
    }

    /*
     * various frontend and visibility settings
     */
    private function fronteEnd() {

        /**
         * shorten resource type and id (for easy appending in blade templates)
         * [usage]
         *   replace the usual url('item') with urlResource('item'), in blade templated
         * */
        if (request('itemresource_type') != '' || is_numeric(request('itemresource_id'))) {
            request()->merge([
                'resource_query' => 'ref=list&itemresource_type=' . request('itemresource_type') . '&itemresource_id=' . request('itemresource_id'),
            ]);
        } else {
            request()->merge([
                'resource_query' => 'ref=list',
            ]);
        }

        //default show some table columns
        config([
            'visibility.items_col_action' => true,
            'visibility.items_col_category' => true,
        ]);

        //default buttons
        config([
            'visibility.list_page_actions_filter_button' => false,
            'visibility.list_page_actions_search' => true,
            'visibility.list_page_actions_filter_button' => true,
            'visibility.items_col_checkboxes' => true,
        ]);

        //trimming content
        config([
            'settings.trimmed_title' => true,
            'settings.item_description' => true,
        ]);

        //permissions -adding editing
        if (auth()->user()->role->role_items >= 2) {
            config([
                //visibility
                'visibility.list_page_actions_add_button' => true,
                'visibility.action_buttons_edit' => true,
                'visibility.list_page_actions_importing' => true,
            ]);
        }

        //permissions -deleting
        if (auth()->user()->role->role_items >= 3) {
            config([
                //visibility
                'visibility.action_buttons_delete' => true,
            ]);
        }

        //calling this fron invoice page
        if (request('itemresource_type') == 'invoice') {
            config([
                'visibility.items_col_action' => false,
                'settings.trimmed_title' => false,
            ]);
        }

        //importing and exporting
        config([
            'visibility.list_page_actions_exporting' => (auth()->user()->role->role_items >= 2) ? true : false,
        ]);
    }
}