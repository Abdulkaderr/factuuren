<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsageValueColumnsToTenants extends Migration
{
    /**
     * Add three missing tenant_usage_value_* columns to the landlord tenants table.
     * These columns are populated by the TenantPlatformUsageCron job.
     */
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->decimal('tenant_usage_value_payments', 20, 2)->default(0.00)->after('tenant_usage_value_estimates');
            $table->decimal('tenant_usage_value_proposals', 20, 2)->default(0.00)->after('tenant_usage_value_payments');
            $table->decimal('tenant_usage_value_contracts', 20, 2)->default(0.00)->after('tenant_usage_value_proposals');
        });
    }

    public function down()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn([
                'tenant_usage_value_payments',
                'tenant_usage_value_proposals',
                'tenant_usage_value_contracts',
            ]);
        });
    }
}
