<?php

/** -------------------------------------------------------------------------------------------------
 * ExecuteQueriesCron
 *
 * This cronjob executes SQL queries on all tenant databases via the landlord database.
 *
 * FEATURES:
 *  - Processes one query at a time to prevent race conditions
 *  - Tracks execution per tenant using the tenant's Updates table
 *  - Supports SQL blocks with individual tracking (prevents duplicate execution)
 *  - Records execution status in landlord execute_queries_logs table
 *
 * SQL BLOCK TRACKING (November 2025):
 *  - Query uniqueid is used as the main "filename" for tracking
 *  - Individual SQL blocks are tracked using block filenames from headers
 *  - Header format: -- [SQL BLOCK]: {file}filename.sql{file}
 *  - Each block is checked against tenant's Updates table before execution
 *  - Previously executed blocks are skipped automatically
 *  - Enables safe re-execution and partial query completion
 *
 * @package    Grow CRM
 * @author     NextLoop
 *---------------------------------------------------------------------------------------------------*/

namespace App\Cronjobs\Landlord;
use DB;
use Exception;
use Log;

class ExecuteQueriesCron {

    public function __invoke() {

        /** -------------------------------------------------------------------------
         * LANDLORD ONLY CHECK
         *
         * This cron must only run in the landlord context, not within tenant databases
         * Exit immediately if we're currently in a tenant context
         * -------------------------------------------------------------------------*/
        if (env('MT_TPYE')) {
            if (\Spatie\Multitenancy\Models\Tenant::current()) {
                return;
            }
        }

        // Run landlord configuration
        runtimeLandlordCronConfig();

        // Execute queries
        $this->executeQueries();
    }

    /**
     * Execute active queries on all tenants
     *
     * This method processes ONE active query at a time across all tenant databases.
     * Each query's execution is tracked in both:
     *  - Landlord database (execute_queries_logs table)
     *  - Each tenant database (updates table for SQL block tracking)
     */
    private function executeQueries() {

        Log::info("[EXECUTE QUERIES] - Process started", ['process' => '[execute-queries-cron]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__]);

        /** -------------------------------------------------------------------------
         * FETCH ONE ACTIVE QUERY (Prevent Race Conditions)
         *
         * Only fetch ONE query at a time to prevent multiple cron instances from
         * processing the same query simultaneously. This ensures:
         *  - No duplicate executions
         *  - Proper status tracking
         *  - Sequential processing of multiple queries
         * -------------------------------------------------------------------------*/
        $query = \App\Models\Landlord\ExecuteQuery::where('execute_query_status', 'active')->first();

        if (!$query) {
            Log::info("[EXECUTE QUERIES] - No active queries found", ['process' => '[execute-queries-cron]', config('app.debug_ref')]);
            return;
        }

        /** -------------------------------------------------------------------------
         * LOCK THE QUERY IMMEDIATELY
         *
         * Change status to 'processing' right away to prevent other cron instances
         * from picking up this same query. This acts as a distributed lock.
         * -------------------------------------------------------------------------*/
        $query->execute_query_status = 'processing';
        $query->save();

        Log::info("[EXECUTE QUERIES] - Processing query {$query->execute_query_uniqueid}", ['process' => '[execute-queries-cron]', config('app.debug_ref'), 'query_id' => $query->execute_query_uniqueid]);

        // Get all tenants
        $tenants = \Spatie\Multitenancy\Models\Tenant::all();
        $total_tenants = $tenants->count();
        $executed_count = 0;

        /** -------------------------------------------------------------------------
         * PROCESS EACH TENANT
         *
         * Loop through all tenants and execute the query on each tenant database.
         * Uses tenant's Updates table to track which blocks have been executed.
         * -------------------------------------------------------------------------*/
        foreach ($tenants as $tenant) {

            /** -------------------------------------------------------------------------
             * CHECK LANDLORD EXECUTION LOG
             *
             * First check if this query has already been logged as executed for this tenant
             * in the landlord database. This is a quick check to skip tenants that have
             * already completed this query successfully.
             * -------------------------------------------------------------------------*/
            $already_executed = \App\Models\Landlord\ExecuteQueryLog::where('execute_queries_log_query_uniqueid', $query->execute_query_uniqueid)
                ->where('execute_queries_log_tenant_id', $tenant->tenant_id)
                ->exists();

            if ($already_executed) {
                $executed_count++;
                continue;
            }

            try {

                /** -------------------------------------------------------------------------
                 * SWITCH TO TENANT DATABASE
                 *
                 * Use multitenancy to switch context to this tenant's database.
                 * All subsequent database operations will be on the tenant database.
                 * -------------------------------------------------------------------------*/
                $tenant->makeCurrent();

                /** -------------------------------------------------------------------------
                 * USE QUERY UNIQUEID AS TRACKING FILENAME
                 *
                 * The query uniqueid serves as the "filename" for tracking in the Updates table
                 * This allows the same tracking mechanism used for SQL update files
                 * -------------------------------------------------------------------------*/
                $main_filename = $query->execute_query_uniqueid;

                /** -------------------------------------------------------------------------
                 * CHECK IF QUERY ALREADY EXECUTED ON THIS TENANT
                 *
                 * Check the tenant's Updates table to see if this query has been run before
                 * This provides idempotent execution - safe to re-activate a completed query
                 * -------------------------------------------------------------------------*/
                if (\App\Models\Update::where('update_mysql_filename', $main_filename)->exists()) {
                    Log::info("[EXECUTE QUERIES] - Query {$main_filename} has already been executed for tenant {$tenant->tenant_id}. Skipping.", ['process' => '[execute-queries-cron]', config('app.debug_ref'), 'tenant_id' => $tenant->tenant_id, 'query_id' => $query->execute_query_uniqueid]);

                    // Still count as executed
                    $executed_count++;
                    continue;
                }

                Log::info("[EXECUTE QUERIES] - Executing on tenant {$tenant->tenant_id} - {$tenant->domain}", ['process' => '[execute-queries-cron]', config('app.debug_ref'), 'tenant_id' => $tenant->tenant_id, 'query_id' => $query->execute_query_uniqueid]);

                // Get SQL content
                $sql = $query->execute_query_sql;

                /** --------------------------------------------------------------------------------------------------------------------------------
                 * EXTRACT BLOCK FILENAMES FROM HEADERS
                 *
                 * For queries with multiple SQL blocks, extract the individual filenames from block headers
                 * Header format: -- [SQL BLOCK]: {file}filename.sql{file}
                 * This creates an array of block filenames that we'll use to track each block individually
                 * If no headers found, this remains an empty array (indicating a simple query without blocks)
                 *
                 * Examples:
                 *  - -- [SQL BLOCK]: {file}add_column.sql{file}
                 *  - -- [SQL BLOCK]: {file}update_settings.sql{file}
                 *  - -- [SQL BLOCK]: {file}create_index.sql{file}
                 * --------------------------------------------------------------------------------------------------------------------------------*/
                $block_filenames = [];
                if (preg_match_all('/-- \[SQL BLOCK\]:\s*\{file\}(.*?)\{file\}/i', $sql, $matches)) {
                    $block_filenames = $matches[1]; // Array of filenames like ['add_column.sql', 'update_settings.sql']
                    Log::info("[EXECUTE QUERIES] - Found " . count($block_filenames) . " SQL blocks for tenant {$tenant->tenant_id}", ['process' => '[execute-queries-cron]', config('app.debug_ref'), 'tenant_id' => $tenant->tenant_id, 'blocks' => $block_filenames]);
                }

                /** --------------------------------------------------------------------------------------------------------------------------------
                 * SPLIT SQL INTO BLOCKS
                 *
                 * Split the SQL content based on the "-- [SQL BLOCK]" marker
                 * Each marker creates a new block that will be tracked and executed independently
                 * If there are no markers, treat the entire SQL as a single block
                 * --------------------------------------------------------------------------------------------------------------------------------*/
                $sql_blocks = preg_split('/-- \[SQL BLOCK\].*?(?:\R|$)/', $sql, -1, PREG_SPLIT_NO_EMPTY);

                // If there were no "-- [SQL BLOCK]" markers, treat the entire SQL as a single block
                if (count($sql_blocks) == 0) {
                    $sql_blocks = [$sql];
                }

                $blocks_executed = 0;
                $blocks_skipped = 0;

                /** --------------------------------------------------------------------------------------------------------------------------------
                 * PROCESS EACH SQL BLOCK WITH INDIVIDUAL TRACKING
                 *
                 * Loop through each block and execute only if it hasn't been run before on this tenant:
                 *  - For queries with block headers: Check if the block's filename exists in tenant's Updates table
                 *  - For simple queries: No block filename, so execute normally (checked at query level above)
                 *  - Record the block filename after successful execution (for queries with blocks)
                 *  - This prevents re-execution if a block was run before, enabling partial query completion
                 * --------------------------------------------------------------------------------------------------------------------------------*/
                foreach ($sql_blocks as $block_index => $sql_block) {

                    // Skip empty blocks
                    if (trim($sql_block) === '') {
                        continue;
                    }

                    $block_filename = null;
                    $should_execute_block = true;

                    /** --------------------------------------------------------------------------------------------------------------------------------
                     * CHECK IF THIS SPECIFIC BLOCK HAS ALREADY BEEN EXECUTED
                     *
                     * For queries with blocks: Each block has a filename (e.g., add_column.sql) extracted from its header
                     * Check if this block filename already exists in the tenant's Updates table
                     * If it exists, skip execution to prevent duplicate runs
                     * This handles cases where:
                     *  - A previous run failed partway through (only failed blocks will execute)
                     *  - Query is manually re-activated (only new/failed blocks execute)
                     * --------------------------------------------------------------------------------------------------------------------------------*/
                    if (!empty($block_filenames) && isset($block_filenames[$block_index])) {
                        $block_filename = $block_filenames[$block_index];

                        // Check if this block has already been executed on this tenant
                        if (\App\Models\Update::where('update_mysql_filename', $block_filename)->exists()) {
                            $should_execute_block = false;
                            $blocks_skipped++;
                            Log::info("[EXECUTE QUERIES] - SQL block ({$block_filename}) has already been executed for tenant {$tenant->tenant_id}. Skipping this block.", ['process' => '[execute-queries-cron]', config('app.debug_ref'), 'tenant_id' => $tenant->tenant_id, 'block_file' => $block_filename]);
                        } else {
                            Log::info("[EXECUTE QUERIES] - SQL block ({$block_filename}) will now be executed for tenant {$tenant->tenant_id}", ['process' => '[execute-queries-cron]', config('app.debug_ref'), 'tenant_id' => $tenant->tenant_id, 'block_file' => $block_filename]);
                        }
                    }

                    /** --------------------------------------------------------------------------------------------------------------------------------
                     * EXECUTE THE SQL BLOCK
                     *
                     * Only execute if the block hasn't been run before on this tenant
                     * After successful execution, record the appropriate filename in tenant's Updates table:
                     *  - For queries with blocks: Record the block filename (e.g., add_column.sql)
                     *  - For simple queries: Record the query uniqueid
                     * --------------------------------------------------------------------------------------------------------------------------------*/
                    if ($should_execute_block) {
                        // Execute the SQL block on the tenant database
                        DB::connection('tenant')->unprepared(trim($sql_block));

                        /** --------------------------------------------------------------------------------------------------------------------------------
                         * RECORD THE EXECUTED BLOCK IN TENANT'S UPDATES TABLE
                         *
                         * Save a record to track this execution in the tenant's Updates table:
                         *  - For queries with blocks: Use the block filename (e.g., add_column.sql) to enable granular tracking
                         *  - For simple queries: Use the query uniqueid - same as main tracking
                         * This prevents re-execution of the same block in future runs
                         * --------------------------------------------------------------------------------------------------------------------------------*/
                        $record = new \App\Models\Update();
                        $record->update_mysql_filename = $block_filename ?: $main_filename;
                        $record->save();

                        $logged_filename = $block_filename ?: $main_filename;
                        $blocks_executed++;
                        Log::info("[EXECUTE QUERIES] - SQL block ({$logged_filename}) executed successfully for tenant {$tenant->tenant_id}", ['process' => '[execute-queries-cron]', config('app.debug_ref'), 'tenant_id' => $tenant->tenant_id, 'executed_file' => $logged_filename]);
                    }
                }

                /** --------------------------------------------------------------------------------------------------------------------------------
                 * RECORD THE MAIN QUERY UNIQUEID AFTER ALL BLOCKS PROCESSED
                 *
                 * After processing all blocks, record the main query uniqueid in tenant's Updates table
                 * This ensures the entire query won't be processed again in future runs, preventing infinite retry loops
                 * Note: Individual block filenames are already recorded in the loop above
                 * This main uniqueid record acts as a marker that the entire query has been fully processed
                 * Any block failures are handled through manual log review rather than automatic retry
                 * --------------------------------------------------------------------------------------------------------------------------------*/
                if (!empty($block_filenames)) {
                    // This was a query with blocks, record the main uniqueid to prevent future re-runs
                    $record = new \App\Models\Update();
                    $record->update_mysql_filename = $main_filename;
                    $record->save();
                    Log::info("[EXECUTE QUERIES] - All blocks processed for query {$main_filename} on tenant {$tenant->tenant_id}. Main query recorded.", ['process' => '[execute-queries-cron]', config('app.debug_ref'), 'tenant_id' => $tenant->tenant_id, 'query_id' => $main_filename, 'blocks_executed' => $blocks_executed, 'blocks_skipped' => $blocks_skipped]);
                }

                /** --------------------------------------------------------------------------------------------------------------------------------
                 * LOG SUCCESS IN LANDLORD DATABASE
                 *
                 * Record successful execution in the landlord's execute_queries_logs table
                 * This provides a centralized view of which queries have been executed on which tenants
                 * Separate from tenant's Updates table which tracks at the block level
                 * --------------------------------------------------------------------------------------------------------------------------------*/
                $log = new \App\Models\Landlord\ExecuteQueryLog();
                $log->setConnection('landlord');
                $log->execute_queries_log_tenant_id = $tenant->tenant_id;
                $log->execute_queries_log_query_uniqueid = $query->execute_query_uniqueid;
                $log->execute_queries_log_tenant_domain = $tenant->domain;
                $log->execute_queries_log_tenant_database = $tenant->database;
                $log->execute_queries_log_status = 'passed';
                $log->save();

                $executed_count++;

                Log::info("[EXECUTE QUERIES] - Success on tenant {$tenant->tenant_id}", ['process' => '[execute-queries-cron]', config('app.debug_ref'), 'tenant_id' => $tenant->tenant_id, 'blocks_executed' => $blocks_executed, 'blocks_skipped' => $blocks_skipped]);

            } catch (Exception $e) {

                /** --------------------------------------------------------------------------------------------------------------------------------
                 * ERROR HANDLING
                 *
                 * If any error occurs during SQL execution:
                 *  - Format the error as HTML for display in the UI
                 *  - Include the error message and the full SQL that was attempted
                 *  - Log the failure in landlord's execute_queries_logs table
                 *  - Count as "executed" to move to next tenant (don't block entire query)
                 *  - Blocks that succeeded are still recorded in tenant's Updates table
                 * --------------------------------------------------------------------------------------------------------------------------------*/
                $error_html = "<div class='error-block'>";
                $error_html .= "<strong>Error:</strong> " . htmlspecialchars($e->getMessage());
                $error_html .= "<br><strong>SQL:</strong><br><pre>" . htmlspecialchars($query->execute_query_sql) . "</pre>";
                $error_html .= "</div>";

                // Log failure in landlord database
                $log = new \App\Models\Landlord\ExecuteQueryLog();
                $log->setConnection('landlord');
                $log->execute_queries_log_tenant_id = $tenant->tenant_id;
                $log->execute_queries_log_query_uniqueid = $query->execute_query_uniqueid;
                $log->execute_queries_log_tenant_domain = $tenant->domain;
                $log->execute_queries_log_tenant_database = $tenant->database;
                $log->execute_queries_log_status = 'failed';
                $log->execute_queries_log_error = $error_html;
                $log->save();

                $executed_count++;

                Log::error("[EXECUTE QUERIES] - Failed on tenant {$tenant->tenant_id}", ['process' => '[execute-queries-cron]', config('app.debug_ref'), 'tenant_id' => $tenant->tenant_id, 'error' => $e->getMessage()]);
            }
        }

        /** -------------------------------------------------------------------------
         * MARK QUERY AS COMPLETED
         *
         * After processing all tenants (successfully or with errors):
         *  - Check if we've processed all tenants
         *  - Change status from 'processing' to 'completed'
         *  - This allows the next active query to be picked up
         *  - Failed tenants are logged but don't prevent completion
         * -------------------------------------------------------------------------*/
        if ($executed_count >= $total_tenants) {
            $query->execute_query_status = 'completed';
            $query->save();

            Log::info("[EXECUTE QUERIES] - Query {$query->execute_query_uniqueid} completed for all tenants", ['process' => '[execute-queries-cron]', config('app.debug_ref'), 'query_id' => $query->execute_query_uniqueid]);
        }

        Log::info("[EXECUTE QUERIES] - Process finished", ['process' => '[execute-queries-cron]', config('app.debug_ref')]);
    }
}
