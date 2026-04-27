<?php

/** ---------------------------------------------------------------------------------------------------------------
 * The purpose of this middleware it to set run updates for the landlord side of the SaaS application
 * It does not run the tenant side of updates (which are done via cronjob)
 *
 *
 *
 * @package    Grow CRM
 * @author     NextLoop
 * @revised    10 May 2023
 *--------------------------------------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Landlord;
use Closure;
use DB;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class Updates {

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //do not run this for SETUP path
        if (env('SETUP_STATUS') != 'COMPLETED') {
            return $next($request);
        }

        if (request()->ajax()) {
            return $next($request);
        }

        //get a list of all the sql files in the updates folder
        $path = BASE_DIR . "/updates-saas";
        $files = File::files($path);
        $updated = false;
        foreach ($files as $file) {

            //file details
            $filename = $file->getFilename();
            $extension = $file->getExtension();
            $filepath = $file->getPathname();

            //runtime function name (e.g. updating_1_13)
            $function_name = str_replace('.sql', '', $filename);
            $function_name = str_replace('.', '_', "landlord_" . $function_name);

            //intial file (version 1.1) that must be run on its own
            if ($filename == '1.1.sql') {
                $updated = $this->initialUpdate($path, $file);
                continue;
            }

            /** --------------------------------------------------------------------------------------------------------------------------------
             * APRIL 2025 - V2.9
             *
             * Starting this version, the SQL file is executed section by section.E.g. 2.9.1.sql; 2.9.2.sql; etc are all now one file 2.9.sql
             *  - Each section is identfied by '-- [SQL BLOCK]' tag
             *  - This enables only single failure points and not the whole file
             *  - The merged sql file is created by addining file to the Python combining app
             *  - Note, the merged file must end with a wrapping -- [SQL BLOCK] as the last line item
             *  - If the file does not have any '-- [SQL BLOCK]' sections, the entire file will be treated as one block and processed
             *
             * OCTOBER 2025 v3.1 - BLOCK-LEVEL TRACKING
             *
             * Enhanced to track individual SQL blocks within combined files to prevent duplicate execution:
             *  - Combined files contain headers like: -- [SQL BLOCK]: {file}3.1.1.sql{file}
             *  - Each block is checked individually against the Updates table before execution
             *  - This allows partial execution if some blocks were previously run individually
             *  - Both individual block filenames AND the main filename are recorded in the database
             *  - Individual files (without block headers) continue to work as before
             *
             * EXECUTION LOGIC:
             * 1. Check if main filename (e.g., 3.1.sql) exists in database → Skip entire file if found
             * 2. For combined files: Extract block filenames from headers (e.g., 3.1.1.sql, 3.1.2.sql)
             * 3. For each block: Check if block filename exists in database
             *    - If exists: Skip that specific block
             *    - If not exists: Execute block and record the block filename
             * 4. After all blocks processed: Record the main filename to prevent future re-runs
             * 5. For individual files: Execute and record the filename (no change from previous behavior)
             * --------------------------------------------------------------------------------------------------------------------------------*/
            if ($extension == 'sql') {
                if (\App\Models\Landlord\Update::On('landlord')->Where('update_mysql_filename', $filename)->doesntExist()) {

                    Log::info("the mysql file ($filename) has not previously been executed. Will now execute it", ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'filename' => $filename]);

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
                        Log::info("found " . count($block_filenames) . " SQL blocks in ($filename)", ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'filename' => $filename, 'blocks' => $block_filenames]);
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
                     * - Record the block filename after successful execution (for combined files)
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
                             * Check if this block filename already exists in the Updates table
                             * If it exists, skip execution to prevent duplicate runs
                             * This handles cases where a block was previously run as an individual file
                             * --------------------------------------------------------------------------------------------------------------------------------*/
                            $block_filename = null;
                            $should_execute_block = true;

                            // If this is a combined file (has block filenames), check if this specific block was already executed
                            if (!empty($block_filenames) && isset($block_filenames[$block_index])) {
                                $block_filename = $block_filenames[$block_index];

                                // Check if this block has already been executed
                                if (\App\Models\Landlord\Update::On('landlord')->Where('update_mysql_filename', $block_filename)->exists()) {
                                    $should_execute_block = false;
                                    Log::info("SQL block ($block_filename) has already been executed previously. Skipping this block.", ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'parent_file' => $filename, 'block_file' => $block_filename]);
                                } else {
                                    Log::info("SQL block ($block_filename) will now be executed", ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'parent_file' => $filename, 'block_file' => $block_filename]);
                                }
                            }

                            /** --------------------------------------------------------------------------------------------------------------------------------
                             * EXECUTE THE SQL BLOCK
                             *
                             * Only execute if the block hasn't been run before
                             * After successful execution, record the appropriate filename:
                             * - For combined files: Record the block filename (e.g., 3.1.1.sql)
                             * - For individual files: Record the main filename (e.g., 3.1.3.sql)
                             * --------------------------------------------------------------------------------------------------------------------------------*/
                            if ($should_execute_block) {
                                // Execute the entire version block as a single operation
                                DB::connection('landlord')->unprepared($sql_block);

                                /** --------------------------------------------------------------------------------------------------------------------------------
                                 * RECORD THE EXECUTED BLOCK IN THE DATABASE
                                 *
                                 * Save a record to track this execution:
                                 * - For combined files: Use the block filename (e.g., 3.1.1.sql) to enable granular tracking
                                 * - For individual files: Use the main filename (e.g., 3.1.3.sql) - same as original behavior
                                 * This prevents re-execution of the same block in future runs
                                 * --------------------------------------------------------------------------------------------------------------------------------*/
                                $record = new \App\Models\Landlord\Update();
                                $record->setConnection('landlord');
                                $record->update_mysql_filename = $block_filename ?: $filename; // Use block filename if available, otherwise main filename
                                $record->save();

                                $logged_filename = $block_filename ?: $filename;
                                Log::info("the mysql file/block ($logged_filename) executed ok", ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'parent_file' => $filename, 'executed_file' => $logged_filename]);
                            }

                        } catch (Exception $e) {
                            $logged_filename = $block_filename ?: $filename;
                            Log::error("the mysql file/block ($logged_filename) could not be executed", ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'parent_file' => $filename, 'error' => $e->getMessage()]);
                        }
                    }

                    /** --------------------------------------------------------------------------------------------------------------------------------
                     * RECORD THE MAIN FILENAME AFTER ALL BLOCKS PROCESSED
                     *
                     * After processing all blocks, record the main filename (e.g., 3.1.sql)
                     * This ensures the entire file won't be processed again in future runs, preventing infinite retry loops
                     * Note: Individual block filenames are already recorded in the loop above
                     * This main filename record acts as a marker that the combined file has been fully processed
                     * Any block failures are handled through manual log review rather than automatic retry
                     * --------------------------------------------------------------------------------------------------------------------------------*/
                    if (!empty($block_filenames)) {
                        // This was a combined file, record the main filename to prevent future re-runs
                        $record = new \App\Models\Landlord\Update();
                        $record->setConnection('landlord');
                        $record->update_mysql_filename = $filename;
                        $record->save();
                        Log::info("all blocks processed for ($filename). Main filename recorded to prevent future re-runs.", ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'filename' => $filename]);
                    }

                    //delete the file
                    try {
                        unlink($path . "/$filename");
                        Log::info("the mysql file ($filename) has been deleted", ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'filename' => $filename]);
                    } catch (Exception $e) {
                        Log::error("the mysql file ($filename) could not be deleted", ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'filename' => $filename]);
                    }

                    /** -------------------------------------------------------------------------
                     * Run any updating function, if it exists
                     * as found in the file - application/updating/landlord_1_1.php ...etc
                     * -------------------------------------------------------------------------*/
                    Log::info("checking if a runtime function: [$function_name()] exists", ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'filename' => $filename]);
                    if (function_exists($function_name)) {

                        Log::info("runtime function: [$function_name()] was found. It will now be executed", ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'filename' => $filename]);

                        try {
                            call_user_func($function_name);
                            Log::info("the runtime function: [$function_name()] was executed", ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'filename' => $filename]);
                        } catch (Exception $e) {
                            Log::critical("updating runtime function: [$function_name()] could not be executed. Error: " . $e->getMessage(), ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'filename' => $filename]);
                        }
                    }

                    //finish
                    Log::info("updating of mysql file ($filename) has been completed", ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'filename' => $filename]);
                } else {
                    try {
                        unlink($path . "/$filename");
                        Log::info("found a non mysql file ($filename) inside the updates folder. Will try to delete it", ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'filename' => $filename]);
                    } catch (Exception $e) {
                        Log::error("the file ($filename) could not be deleted", ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'filename' => $filename]);
                    }
                }

                //we have done an update
                $updated = true;
            }
        }

        //finish - clear cache
        if ($updated) {
            \Artisan::call('cache:clear');
            \Artisan::call('route:clear');
            \Artisan::call('config:clear');
            \Artisan::call('view:clear');
        }

        return $next($request);
    }

    /**
     * Inital update which creates the 'updates' database table which is needed for future updates
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function initialUpdate($path, $file) {

        Log::info("the sql file is v1.1 will now execute it.", ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);

        //file details
        $filename = $file->getFilename();
        $extension = $file->getExtension();
        $filepath = $file->getPathname();

        //execute the SQL (only for CRM with version 1.0)
        if (config('system.settings_version') == '1.0') {
            try {
                //db
                DB::unprepared(file_get_contents($filepath));
                Log::info("the mysql file ($filename) executed ok - will now delete it", ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            } catch (Exception $e) {
                Log::error("the mysql file ($filename) could not be executed. error: " . $e->getMessage(), ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
                return false;
            }
        } else {
            Log::info("the system has already been updated beyond this sql version.", ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        }

        //delete the file
        try {
            unlink($path . "/$filename");
        } catch (Exception $e) {
            Log::error("the mysql file ($filename) could not be deleted. error: " . $e->getMessage(), ['process' => '[landlord-updates]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

        return true;

    }

}
