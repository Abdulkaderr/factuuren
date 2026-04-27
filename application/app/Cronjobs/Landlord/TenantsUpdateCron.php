<?php

/** -------------------------------------------------------------------------------------------------
 * TenantsCronStatus
 * This cronjob is just used to record whether the tenant cronjobs have executed
 * This cron actually executes during the 'tenants' cron jobs run
 * @package    Grow CRM
 * @author     NextLoop
 *---------------------------------------------------------------------------------------------------*/

namespace App\Cronjobs\Landlord;
use DB;
use Exception;
use Illuminate\Support\Facades\Schema;
use Log;

class TenantsUpdateCron {

    public function __invoke() {

        //[MT] - landlord only
        if (env('MT_TPYE')) {
            if (\Spatie\Multitenancy\Models\Tenant::current()) {
                return;
            }
        }

        //[MT] - run config settings for landlord
        runtimeLandlordCronConfig();

        //only do this if the landord database is updated to v1.3 and above
        if (Schema::connection('landlord')->hasColumn('tenants', 'tenant_updating_current_version')) {
            $this->updateTenantsDB();
        }

    }

    /**
     * Update each tenant database
     */
    public function updateTenantsDB() {

        Log::info("[UPDATING] - tenants updating process has started. Looking for tenants to update - started", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);

        //current version
        $target_system_version = config('system.settings_version');

        //check if we have an x.sql file to match this version
        $filepath = BASE_DIR . "/updates/$target_system_version.sql";
        $filename = "$target_system_version.sql";

        //only do the update if the file exists
        if (!file_exists($filepath)) {
            //log as info and not error
            Log::info("[UPDATING] - tenants updating process halted. The sql file ($target_system_version.sql) could not be found.It may not be required for this version ($target_system_version)", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return;
        }

        //counts
        $count_passed = 0;
        $count_failed = 0;

        //get all customers with a version less than the system version and are not in (failed) or (processing) status
        $limit = 5;
        $customers = \App\Models\Landlord\Tenant::on('landlord')
            ->where('tenant_updating_status', 'completed')
            ->where(function ($query) use ($target_system_version) {
                $query->where('tenant_updating_current_version', '<', $target_system_version)
                    ->orWhereNull('tenant_updating_current_version');
            })
            ->take($limit)
            ->get();

        //count
        $count = $customers->count();

        //count how many we are updating
        if ($count == 0) {
            Log::info("[UPDATING] - no tenants were found that are eligable for an update to version ($target_system_version)", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return;
        } else {
            Log::info("[UPDATING] - found ($count) tenants that are eligable for an update to version ($target_system_version)", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        }

        //mark each tenant as updating
        foreach ($customers as $customer) {
            $customer->update([
                'tenant_updating_status' => 'processing',
                'tenant_updating_target_version' => $target_system_version,
            ]);
        }

        //update each tenant
        foreach ($customers as $customer) {

            \Spatie\Multitenancy\Models\Tenant::forgetCurrent();

            Log::info("[UPDATING] - updating database for tenant id (" . $customer->tenant_id . ") - domain (" . $customer->domain . ") - started", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);

            //get the customer from landlord db
            if ($tenant = \Spatie\Multitenancy\Models\Tenant::Where('tenant_id', $customer->tenant_id)->first()) {
                try {

                    /** ---------------------------------------------------------------------------------------------------------------------------
                     * OCTOBER 2025 v3.1 - BLOCK-LEVEL TRACKING (Same logic as UpdateServiceProvider)
                     *
                     * Enhanced to track individual SQL blocks within combined files to prevent duplicate execution:
                     *  - Combined files contain headers like: -- [SQL BLOCK]: {file}3.1.1.sql{file}
                     *  - Each block is checked individually against the Updates table (in tenant DB) before execution
                     *  - This allows partial execution if some blocks were previously run individually
                     *  - Both individual block filenames AND the main filename are recorded in the tenant database
                     *  - Individual files (without block headers) continue to work as before
                     *
                     * EXECUTION LOGIC:
                     * 1. Check if main filename (e.g., 3.1.sql) exists in tenant database → Skip entire file if found
                     * 2. For combined files: Extract block filenames from headers (e.g., 3.1.1.sql, 3.1.2.sql)
                     * 3. For each block: Check if block filename exists in tenant database
                     *    - If exists: Skip that specific block
                     *    - If not exists: Execute block and record the block filename in tenant DB
                     * 4. After all blocks processed: Record the main filename to prevent future re-runs
                     * 5. For individual files: Execute and record the filename (no change from previous behavior)
                     * --------------------------------------------------------------------------------------------------------------------------*/

                    //swicth to this tenants DB
                    $tenant->makeCurrent();

                    //check if this entire file has already been processed for this tenant
                    if (\App\Models\Update::Where('update_mysql_filename', $filename)->exists()) {
                        Log::info("[UPDATING] - the mysql file ($filename) has already been executed for tenant {$customer->tenant_id}. Skipping this file.", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'tenant_id' => $customer->tenant_id]);

                        //update tenant record (in landlord db) - still mark as completed
                        $customer->tenant_updating_status = 'completed';
                        $customer->tenant_updating_current_version = $target_system_version;
                        $customer->save();

                        //skip to next tenant
                        continue;
                    }

                    Log::info("[UPDATING] - the mysql file ($filename) has not previously been executed for tenant {$customer->tenant_id}. Will now execute it", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'tenant_id' => $customer->tenant_id]);

                    // Read the contents of the SQL file
                    $sql_content = file_get_contents($filepath);

                    /** --------------------------------------------------------------------------------------------------------------------------------
                     * EXTRACT BLOCK FILENAMES FROM HEADERS (Combined Files Only)
                     *
                     * For combined SQL files, extract the individual filenames from block headers
                     * Header format: -- [SQL BLOCK]: {file}3.1.1.sql{file}
                     * This creates an array of block filenames that we'll use to track each block individually
                     * If no headers found, this remains an empty array (indicating an individual file)
                     * --------------------------------------------------------------------------------------------------------------------------------*/
                    $block_filenames = [];
                    if (preg_match_all('/-- \[SQL BLOCK\]:\s*\{file\}(.*?)\{file\}/i', $sql_content, $matches)) {
                        $block_filenames = $matches[1]; // Array of filenames like ['3.1.1.sql', '3.1.2.sql', '3.1.3.sql']
                        Log::info("[UPDATING] - found " . count($block_filenames) . " SQL blocks in ($filename) for tenant {$customer->tenant_id}", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'tenant_id' => $customer->tenant_id, 'blocks' => $block_filenames]);
                    }

                    // Split the SQL content into blocks based on the "-- [SQL BLOCK]" marker found in the sql file
                    $sql_blocks = preg_split('/-- \[SQL BLOCK\].*?(?:\R|$)/', $sql_content, -1, PREG_SPLIT_NO_EMPTY);

                    // If there were no "-- [SQL BLOCK]" markers, treat the entire file as a single block
                    if (count($sql_blocks) == 0) {
                        $sql_blocks = [$sql_content];
                    }

                    /** --------------------------------------------------------------------------------------------------------------------------------
                     * PROCESS EACH SQL BLOCK WITH INDIVIDUAL TRACKING
                     *
                     * Loop through each block and execute only if it hasn't been run before:
                     * - For combined files: Check if the block's filename (e.g., 3.1.1.sql) exists in Updates table
                     * - For individual files: No block filename, so execute normally (checked at file level above)
                     * - Record the block filename in tenant DB after successful execution (for combined files)
                     * - This prevents re-execution if a block was run individually before being added to a combined file
                     * --------------------------------------------------------------------------------------------------------------------------------*/
                    foreach ($sql_blocks as $block_index => $sql_block) {
                        try {
                            // Skip empty blocks
                            if (trim($sql_block) === '') {
                                continue;
                            }

                            /** --------------------------------------------------------------------------------------------------------------------------------
                             * CHECK IF THIS SPECIFIC BLOCK HAS ALREADY BEEN EXECUTED
                             *
                             * For combined files: Each block has a filename (e.g., 3.1.1.sql) extracted from its header
                             * Check if this block filename already exists in the Updates table (in tenant DB)
                             * If it exists, skip execution to prevent duplicate runs
                             * This handles cases where a block was previously run as an individual file
                             * --------------------------------------------------------------------------------------------------------------------------------*/
                            $block_filename = null;
                            $should_execute_block = true;

                            // If this is a combined file (has block filenames), check if this specific block was already executed
                            if (!empty($block_filenames) && isset($block_filenames[$block_index])) {
                                $block_filename = $block_filenames[$block_index];

                                // Check if this block has already been executed for this tenant
                                if (\App\Models\Update::Where('update_mysql_filename', $block_filename)->exists()) {
                                    $should_execute_block = false;
                                    Log::info("[UPDATING] - SQL block ($block_filename) has already been executed previously for tenant {$customer->tenant_id}. Skipping this block.", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'tenant_id' => $customer->tenant_id, 'parent_file' => $filename, 'block_file' => $block_filename]);
                                } else {
                                    Log::info("[UPDATING] - SQL block ($block_filename) will now be executed for tenant {$customer->tenant_id}", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'tenant_id' => $customer->tenant_id, 'parent_file' => $filename, 'block_file' => $block_filename]);
                                }
                            }

                            /** --------------------------------------------------------------------------------------------------------------------------------
                             * EXECUTE THE SQL BLOCK
                             *
                             * Only execute if the block hasn't been run before
                             * After successful execution, record the appropriate filename in tenant DB:
                             * - For combined files: Record the block filename (e.g., 3.1.1.sql)
                             * - For individual files: Record the main filename (e.g., 3.1.3.sql)
                             * --------------------------------------------------------------------------------------------------------------------------------*/
                            if ($should_execute_block) {
                                // Execute the entire version block as a single operation
                                DB::connection('tenant')->unprepared($sql_block);

                                /** --------------------------------------------------------------------------------------------------------------------------------
                                 * RECORD THE EXECUTED BLOCK IN THE TENANT DATABASE
                                 *
                                 * Save a record to track this execution in the tenant's Updates table:
                                 * - For combined files: Use the block filename (e.g., 3.1.1.sql) to enable granular tracking
                                 * - For individual files: Use the main filename (e.g., 3.1.3.sql) - same as original behavior
                                 * This prevents re-execution of the same block in future runs
                                 * --------------------------------------------------------------------------------------------------------------------------------*/
                                $record = new \App\Models\Update();
                                $record->update_mysql_filename = $block_filename ?: $filename; // Use block filename if available, otherwise main filename
                                $record->save();

                                $logged_filename = $block_filename ?: $filename;
                                Log::info("[UPDATING] - the mysql file/block ($logged_filename) executed ok for tenant {$customer->tenant_id}", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'tenant_id' => $customer->tenant_id, 'parent_file' => $filename, 'executed_file' => $logged_filename]);
                            }

                        } catch (Exception $e) {
                            // Log the error but continue with the next version block
                            $logged_filename = $block_filename ?: $filename;
                            Log::error("[UPDATING] - the mysql file/block ($logged_filename) could not be executed for tenant {$customer->tenant_id}: " . $e->getMessage(), ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'tenant_id' => $customer->tenant_id, 'parent_file' => $filename, 'error' => $e->getMessage()]);
                        }
                    }

                    /** --------------------------------------------------------------------------------------------------------------------------------
                     * RECORD THE MAIN FILENAME AFTER ALL BLOCKS PROCESSED
                     *
                     * After processing all blocks, record the main filename (e.g., 3.1.sql) in tenant DB
                     * This ensures the entire file won't be processed again in future runs, preventing infinite retry loops
                     * Note: Individual block filenames are already recorded in the loop above
                     * This main filename record acts as a marker that the combined file has been fully processed
                     * Any block failures are handled through manual log review rather than automatic retry
                     * --------------------------------------------------------------------------------------------------------------------------------*/
                    if (!empty($block_filenames)) {
                        // This was a combined file, record the main filename to prevent future re-runs
                        $record = new \App\Models\Update();
                        $record->update_mysql_filename = $filename;
                        $record->save();
                        Log::info("[UPDATING] - all blocks processed for ($filename) for tenant {$customer->tenant_id}. Main filename recorded to prevent future re-runs.", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'tenant_id' => $customer->tenant_id, 'filename' => $filename]);
                    }

                    //update tenant record (in landlord db)
                    $customer->tenant_updating_status = 'completed';
                    $customer->tenant_updating_current_version = $target_system_version;
                    $customer->save();

                    //log this event
                    $log = new \App\Models\Landlord\Updatelog();
                    $log->setConnection('landlord');
                    $log->updateslog_tenant_id = $customer->tenant_id;
                    $log->updateslog_tenant_database = $customer->database;
                    $log->updateslog_current_version = $customer->tenant_updating_current_version;
                    $log->updateslog_target_version = $target_system_version;
                    $log->updateslog_status = 'completed';
                    $log->save();

                    $count_passed++;
                    Log::info("[UPDATING] - updating database for tenant id (" . $customer->tenant_id . ") - domain (" . $customer->domain . ") - completed", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);

                } catch (Exception $e) {

                    //update tenant record (in landlord db)
                    $customer->tenant_updating_status = 'failed';
                    $customer->tenant_updating_log = $e->getMessage();
                    $customer->save();

                    //log this error
                    $log = new \App\Models\Landlord\Updatelog();
                    $log->setConnection('landlord');
                    $log->updateslog_tenant_id = $customer->tenant_id;
                    $log->updateslog_tenant_database = $customer->database;
                    $log->updateslog_current_version = $customer->tenant_updating_current_version;
                    $log->updateslog_target_version = $target_system_version;
                    $log->updateslog_status = 'failed';
                    $log->updateslog_notes = $e->getMessage();
                    $log->save();

                    $count_failed++;
                    Log::error("[UPDATING] - updating database for tenant id (" . $customer->tenant_id . ") - domain (" . $customer->domain . ") - failed - see crm log table", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
                }
            }

        }

        Log::info("[UPDATING] - tenants updating process has finshed. passed ($count_passed) - failed ($count_failed)", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);

    }

}