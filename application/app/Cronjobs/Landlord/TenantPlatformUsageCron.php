<?php

/** -------------------------------------------------------------------------------------------------
 * [LANDLORD] [CRONJOB]
 * Tenant Platform Usage — Collect and store per-tenant usage statistics
 *
 * PURPOSE:
 * Connects to each tenant's database and collects 20 platform usage metrics,
 * then writes them back to the tenant's record in the landlord tenants table.
 * This provides the landlord dashboard with up-to-date usage data per tenant.
 *
 * ARCHITECTURE:
 * - Runs from LANDLORD context only (not tenant)
 * - Connects to individual tenant databases to query usage data
 * - Writes collected data back to the landlord tenants table
 * - Uses tenant_platform_usage_cron_status to manage batch processing
 *
 * EXECUTION:
 * - Runs every minute via Laravel scheduler
 * - Processes up to 10 tenants per run ($limit = 10)
 * - Marks tenants as 'processing' immediately to prevent race conditions
 * - Includes cleanup for tenants stuck in processing (> 10 minutes)
 *
 * STATUS CYCLE:
 * pending → processing → completed → pending (reset when all completed)
 *
 * @package    Grow CRM
 * @author     NextLoop
 *---------------------------------------------------------------------------------------------------*/

namespace App\Cronjobs\Landlord;

use App\Models\Landlord\Tenant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TenantPlatformUsageCron {

    /**
     * Maximum number of tenants to process per cron run
     * @var int
     */
    protected $limit;

    /**
     * Domain of the tenant currently being processed (used for logging)
     * @var string
     */
    protected $tenant_domain;

    /**
     * Main cron job entry point — invoked by Laravel scheduler
     *
     * PURPOSE: Entry point for the Laravel scheduler.
     * PROCESS:
     * 1. Guard to ensure this runs in landlord context only
     * 2. Boot landlord config settings
     * 3. Set processing limit
     * 4. Delegate to processTenants()
     *
     * @return void
     */
    public function __invoke() {

        Log::info("Starting tenant platform usage processing", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__]);

        //[MT] - landlord only
        if (env('MT_TPYE')) {
            if (\Spatie\Multitenancy\Models\Tenant::current()) {
                return;
            }
        }

        //[MT] - run config settings for landlord
        runtimeLandlordCronConfig();

        $this->limit = 10;

        $this->processTenants();

        Log::info("Completed tenant platform usage processing", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__]);
    }

    /**
     * Manage the tenant processing queue and orchestrate data collection
     *
     * PURPOSE: Fetch the next batch of pending tenants, mark them as processing,
     * connect to each tenant's database, collect 20 usage metrics, and write
     * the results back to the landlord tenants table.
     *
     * PROCESS:
     * 1. Fetch up to $limit tenants with status 'pending'
     * 2. If none pending: reset stuck tenants, mark all others as pending, return
     * 3. Mark fetched tenants as 'processing' immediately (race condition prevention)
     * 4. Loop through each tenant, collect metrics, update record
     *
     * @return void
     */
    private function processTenants() {

        // Fetch the next batch of pending tenants
        $tenants = Tenant::where('tenant_platform_usage_cron_status', 'pending')
            ->limit($this->limit)
            ->get();

        Log::info("Found (" . $tenants->count() . ") pending tenants to process", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__]);

        // If no pending tenants, reset the batch for the next cycle
        if ($tenants->isEmpty()) {

            Log::info("No pending tenants found — resetting batch", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__]);

            // Reset any tenants stuck in processing for more than 10 minutes
            Tenant::where('tenant_platform_usage_cron_status', 'processing')
                ->where('tenant_platform_usage_cron_last_run', '<', Carbon::now()->subMinutes(10))
                ->update(['tenant_platform_usage_cron_status' => 'pending']);

            // Mark all non-processing tenants as pending for the next batch cycle
            // (tenants still processing within 10 minutes are left untouched)
            $count = Tenant::where('tenant_platform_usage_cron_status', '!=', 'processing')
                ->update(['tenant_platform_usage_cron_status' => 'pending']);

            Log::info("Batch reset complete — ($count) tenants marked as pending", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__]);

            return;
        }

        // CRITICAL: Mark all fetched tenants as 'processing' immediately to prevent race conditions
        foreach ($tenants as $tenant) {
            $tenant->tenant_platform_usage_cron_status = 'processing';
            $tenant->tenant_platform_usage_cron_last_run = Carbon::now();
            $tenant->save();
        }

        // Process each tenant
        foreach ($tenants as $tenant) {

            try {

                // Connect to this tenant's database
                if (!$this->connectToTenantDatabase($tenant)) {
                    Log::error("Skipping tenant — could not connect to database", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'tenant_id' => $tenant->tenant_id]);
                    continue;
                }

                // Collect all 20 usage metrics from the tenant database
                $data = [
                    'tenant_usage_count_team' => $this->countTeam(),
                    'tenant_usage_count_clients' => $this->countClients(),
                    'tenant_usage_count_projects' => $this->countProjects(),
                    'tenant_usage_count_tasks' => $this->countTasks(),
                    'tenant_usage_count_leads' => $this->countLeads(),
                    'tenant_usage_count_invoices' => $this->countInvoices(),
                    'tenant_usage_count_estimates' => $this->countEstimates(),
                    'tenant_usage_count_proposals' => $this->countProposals(),
                    'tenant_usage_count_contracts' => $this->countContracts(),
                    'tenant_usage_count_tickets' => $this->countTickets(),
                    'tenant_usage_count_emails_queued' => $this->countEmailsQueued(),
                    'tenant_usage_count_emails_sent' => $this->countEmailsSent(),
                    'tenant_usage_count_emails_processing' => $this->countEmailsProcessingStuck(),
                    'tenant_usage_value_invoices' => $this->sumInvoicesPaid(),
                    'tenant_usage_value_estimates' => $this->sumEstimatesAccepted(),
                    'tenant_usage_value_payments' => $this->sumPayments(),
                    'tenant_usage_value_proposals' => $this->sumProposalsAccepted(),
                    'tenant_usage_value_contracts' => $this->sumContractsActive(),
                    'tenant_usage_value_leads_converted' => $this->sumLeadsConverted(),
                ];

                //get additional data
                $currency = $this->getCurrencySymbol();
                $cronjob_last_run = $this->getCronjobLastRun();
                $email_server_type = $this->getEmailServerType();

                $currency_position = $this->getCurrencyPosition();
                $decimal_separator = $this->getDecimalSeparator();
                $thousand_separator = $this->getThousandSeparator();

                // Disconnect from tenant database before writing back to landlord
                \Spatie\Multitenancy\Models\Tenant::forgetCurrent();

                // Write collected data to the landlord tenant record
                $tenant->fill($data);
                $tenant->tenant_settings_currency_symbol = $currency;
                $tenant->tenant_settings_cronjob_last_run = $cronjob_last_run;
                $tenant->tenant_settings_email_services = $email_server_type;

                $tenant->tenant_settings_currency_position = $currency_position;
                $tenant->tenant_settings_decimal_separator = $decimal_separator;
                $tenant->tenant_settings_thousand_separator = $thousand_separator;


                $tenant->tenant_platform_usage_cron_status = 'completed';
                $tenant->save();

                Log::info("Tenant platform usage updated", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'tenant_id' => $tenant->tenant_id]);

            } catch (\Exception$e) {

                Log::error("Error processing tenant platform usage", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'tenant_id' => $tenant->tenant_id, 'error' => $e->getMessage()]);

                // Ensure tenant connection is always reset on error
                \Spatie\Multitenancy\Models\Tenant::forgetCurrent();

                continue;
            }
        }
    }

    /**
     * Connect to a tenant's database
     *
     * PURPOSE: Switch the active database connection to the specified tenant.
     * PROCESS:
     * 1. Reset any existing tenant connection
     * 2. Find the Spatie tenant model by tenant_id
     * 3. Call makeCurrent() to switch the DB connection
     *
     * NOTE: Uses \Spatie\Multitenancy\Models\Tenant with full namespace to avoid
     * naming conflict with the imported App\Models\Landlord\Tenant class.
     *
     * @param  Tenant $tenant  The landlord Tenant model instance
     * @return bool  True on success, false on failure
     */
    private function connectToTenantDatabase($tenant) {

        try {

            // Reset any existing tenant connection first
            \Spatie\Multitenancy\Models\Tenant::forgetCurrent();

            if ($tenant_connection = \Spatie\Multitenancy\Models\Tenant::where('tenant_id', $tenant->tenant_id)->first()) {
                $tenant_connection->makeCurrent();
                $this->tenant_domain = $tenant_connection->domain;
                Log::info("Connected to tenant database", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'tenant_id' => $tenant->tenant_id, 'domain' => $this->tenant_domain]);
                return true;
            }

            Log::error("Tenant connection object not found", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'tenant_id' => $tenant->tenant_id]);
            return false;

        } catch (\Exception$e) {
            Log::error("Failed to connect to tenant database", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'tenant_id' => $tenant->tenant_id, 'error' => $e->getMessage()]);
            \Spatie\Multitenancy\Models\Tenant::forgetCurrent();
            return false;
        }
    }

    // -----------------------------------------------------------------------
    // COUNT METHODS — return integer counts from the tenant database
    // -----------------------------------------------------------------------

    /**
     * Count team members (users with type = 'team')
     * @return int
     */
    private function countTeam() {
        try {
            $count = \App\Models\User::where('type', 'team')->count();
            Log::info("count_team: ($count)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
            return $count;
        } catch (\Exception$e) {
            Log::error("Error collecting count_team", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Count all clients
     * @return int
     */
    private function countClients() {
        try {
            $count = \App\Models\Client::count();
            Log::info("count_clients: ($count)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
            return $count;
        } catch (\Exception$e) {
            Log::error("Error collecting count_clients", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Count projects (project_type = 'project')
     * @return int
     */
    private function countProjects() {
        try {
            $count = \App\Models\Project::where('project_type', 'project')->count();
            Log::info("count_projects: ($count)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
            return $count;
        } catch (\Exception$e) {
            Log::error("Error collecting count_projects", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Count all tasks
     * @return int
     */
    private function countTasks() {
        try {
            $count = \App\Models\Task::count();
            Log::info("count_tasks: ($count)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
            return $count;
        } catch (\Exception$e) {
            Log::error("Error collecting count_tasks", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Count all leads
     * @return int
     */
    private function countLeads() {
        try {
            $count = \App\Models\Lead::count();
            Log::info("count_leads: ($count)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
            return $count;
        } catch (\Exception$e) {
            Log::error("Error collecting count_leads", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Count all invoices
     * @return int
     */
    private function countInvoices() {
        try {
            $count = \App\Models\Invoice::count();
            Log::info("count_invoices: ($count)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
            return $count;
        } catch (\Exception$e) {
            Log::error("Error collecting count_invoices", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Count all estimates
     * @return int
     */
    private function countEstimates() {
        try {
            $count = \App\Models\Estimate::count();
            Log::info("count_estimates: ($count)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
            return $count;
        } catch (\Exception$e) {
            Log::error("Error collecting count_estimates", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Count all proposals
     * @return int
     */
    private function countProposals() {
        try {
            $count = \App\Models\Proposal::count();
            Log::info("count_proposals: ($count)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
            return $count;
        } catch (\Exception$e) {
            Log::error("Error collecting count_proposals", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Count all contracts
     * @return int
     */
    private function countContracts() {
        try {
            $count = \App\Models\Contract::count();
            Log::info("count_contracts: ($count)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
            return $count;
        } catch (\Exception$e) {
            Log::error("Error collecting count_contracts", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Count all support tickets
     * @return int
     */
    private function countTickets() {
        try {
            $count = \App\Models\Ticket::count();
            Log::info("count_tickets: ($count)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
            return $count;
        } catch (\Exception$e) {
            Log::error("Error collecting count_tickets", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Count all queued emails
     * @return int
     */
    private function countEmailsQueued() {
        try {
            $count = \App\Models\EmailQueue::count();
            Log::info("count_emails_queued: ($count)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
            return $count;
        } catch (\Exception$e) {
            Log::error("Error collecting count_emails_queued", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Count all sent emails (email log entries)
     * @return int
     */
    private function countEmailsSent() {
        try {
            $count = \App\Models\EmailLog::count();
            Log::info("count_emails_sent: ($count)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
            return $count;
        } catch (\Exception$e) {
            Log::error("Error collecting count_emails_sent", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Count emails stuck in processing for more than 1 hour
     * Only counts emails that appear to have stalled, not those actively being processed
     *
     * @return int
     */
    private function countEmailsProcessingStuck() {
        try {
            $count = \App\Models\EmailQueue::where('emailqueue_status', 'processing')
                ->where('emailqueue_started_at', '<', Carbon::now()->subHour())
                ->count();
            Log::info("count_emails_processing_stuck: ($count)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
            return $count;
        } catch (\Exception$e) {
            Log::error("Error collecting count_emails_processing", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return 0;
        }
    }

    // -----------------------------------------------------------------------
    // VALUE METHODS — return monetary sums from the tenant database
    // -----------------------------------------------------------------------

    /**
     * Sum bill_final_amount for paid invoices (bill_status = 5)
     * @return float
     */
    private function sumInvoicesPaid() {
        try {
            $value = \App\Models\Invoice::where('bill_status', 5)->sum('bill_final_amount');
            Log::info("value_invoices: ($value)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
            return $value;
        } catch (\Exception$e) {
            Log::error("Error collecting value_invoices", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Sum bill_final_amount for accepted estimates (bill_status = 'accepted')
     * @return float
     */
    private function sumEstimatesAccepted() {
        try {
            $value = \App\Models\Estimate::where('bill_status', 'accepted')->sum('bill_final_amount');
            Log::info("value_estimates: ($value)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
            return $value;
        } catch (\Exception$e) {
            Log::error("Error collecting value_estimates", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Sum payment_amount across all payments
     * @return float
     */
    private function sumPayments() {
        try {
            $value = \App\Models\Payment::sum('payment_amount');
            Log::info("value_payments: ($value)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
            return $value;
        } catch (\Exception$e) {
            Log::error("Error collecting value_payments", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Sum bill_final_amount of estimates linked to accepted proposals
     *
     * PROCESS: Joins proposals to estimates where bill_estimate_type = 'document'
     * and bill_proposalid = doc_id, filtered to doc_status = 'accepted'
     *
     * @return float
     */
    private function sumProposalsAccepted() {
        try {
            $value = \App\Models\Proposal::where('proposals.doc_status', 'accepted')
                ->join('estimates', function ($join) {
                    $join->on('estimates.bill_proposalid', '=', 'proposals.doc_id')
                        ->where('estimates.bill_estimate_type', 'document');
                })
                ->sum('estimates.bill_final_amount');
            Log::info("value_proposals: ($value)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
            return $value;
        } catch (\Exception$e) {
            Log::error("Error collecting value_proposals", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Sum bill_final_amount of estimates linked to active contracts
     *
     * PROCESS: Joins contracts to estimates where bill_estimate_type = 'document'
     * and bill_contractid = doc_id, filtered to doc_status = 'active'
     *
     * @return float
     */
    private function sumContractsActive() {
        try {
            $value = \App\Models\Contract::where('contracts.doc_status', 'active')
                ->join('estimates', function ($join) {
                    $join->on('estimates.bill_contractid', '=', 'contracts.doc_id')
                        ->where('estimates.bill_estimate_type', 'document');
                })
                ->sum('estimates.bill_final_amount');
            Log::info("value_contracts: ($value)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
            return $value;
        } catch (\Exception$e) {
            Log::error("Error collecting value_contracts", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Sum lead_value for converted leads (lead_converted = 'yes')
     * @return float
     */
    private function sumLeadsConverted() {
        try {
            $value = \App\Models\Lead::where('lead_converted', 'yes')->sum('lead_value');
            Log::info("value_leads_converted: ($value)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
            return $value;
        } catch (\Exception$e) {
            Log::error("Error collecting value_leads_converted", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return 0;
        }
    }

    // -----------------------------------------------------------------------
    // SETTINGS METHOD
    // -----------------------------------------------------------------------

    /**
     * Get the tenant's currency symbol from their settings table
     *
     * @return string|null  Returns null if settings record not found (caller skips the update)
     */
    private function getCurrencySymbol() {
        try {
            if ($settings = \App\Models\Settings::first()) {
                $symbol = $settings->settings_system_currency_symbol;
                Log::info("currency_symbol: ($symbol)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
                return $symbol;
            }
            return null;
        } catch (\Exception$e) {
            Log::error("Error collecting settings_currency_symbol", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Get the tenant's last cronjob run timestamp from their settings table
     *
     * @return string|null  Returns null if settings record not found (caller skips the update)
     */
    private function getCronjobLastRun() {
        try {
            if ($settings = \App\Models\Settings::first()) {
                $value = $settings->settings_cronjob_last_run;
                Log::info("settings_cronjob_last_run: ($value)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
                return $value;
            }
            return null;
        } catch (\Exception$e) {
            Log::error("Error collecting settings_cronjob_last_run", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Get the tenant's currency position from their settings table (left|right)
     *
     * @return string|null  Returns null if settings record not found (caller skips the update)
     */
    private function getCurrencyPosition() {
        try {
            if ($settings = \App\Models\Settings::first()) {
                $value = $settings->settings_system_currency_position;
                Log::info("settings_system_currency_position: ($value)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
                return $value;
            }
            return null;
        } catch (\Exception$e) {
            Log::error("Error collecting settings_system_currency_position", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Get the tenant's decimal separator from their settings table (fullstop|comma)
     *
     * @return string|null  Returns null if settings record not found (caller skips the update)
     */
    private function getDecimalSeparator() {
        try {
            if ($settings = \App\Models\Settings::first()) {
                $value = $settings->settings_system_decimal_separator;
                Log::info("settings_system_decimal_separator: ($value)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
                return $value;
            }
            return null;
        } catch (\Exception$e) {
            Log::error("Error collecting settings_system_decimal_separator", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Get the tenant's thousand separator from their settings table (comma|fullstop|apostrophe|space|none)
     *
     * @return string|null  Returns null if settings record not found (caller skips the update)
     */
    private function getThousandSeparator() {
        try {
            if ($settings = \App\Models\Settings::first()) {
                $value = $settings->settings_system_thousand_separator;
                Log::info("settings_system_thousand_separator: ($value)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
                return $value;
            }
            return null;
        } catch (\Exception$e) {
            Log::error("Error collecting settings_system_thousand_separator", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Get the tenant's email server type from their settings table
     *
     * @return string|null  Returns null if settings record not found (caller skips the update)
     */
    private function getEmailServerType() {
        try {
            if ($settings = \App\Models\Settings::first()) {
                $value = $settings->settings_saas_email_server_type;
                Log::info("settings_saas_email_server_type: ($value)", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'domain' => $this->tenant_domain]);
                return $value;
            }
            return null;
        } catch (\Exception$e) {
            Log::error("Error collecting settings_saas_email_server_type", ['tenant-platform-usage-cronjob', config('app.debug_ref'), basename(__FILE__), __line__, 'error' => $e->getMessage()]);
            return null;
        }
    }
}
