<div class="platform-usage p-t-10">

    <!--activity-->
    <div class="x-heading font-weight-bold">@lang('lang.activity')</div>
    <table class="table no-border">
        <tbody>
            <tr>
                <td>@lang('lang.last_logged_in')</td>
                <td class="font-medium w-30">
                    @if($customer->tenant_tracking_activity_last_seen)
                        {{ runtimeDate($customer->tenant_tracking_activity_last_seen) }} @ {{ \Carbon\Carbon::parse($customer->tenant_tracking_activity_last_seen)->format('H:i') }}
                    @else
                        ---
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <div class="line m-t-20 m-b-30"></div>

    <!--system health-->
    <div class="x-heading font-weight-bold">@lang('lang.system_health')</div>
    <table class="table no-border">
        <tbody>
            <tr>
                <td>@lang('lang.cronjob_last_run')</td>
                <td class="font-medium w-30">
                    @if($customer->tenant_settings_cronjob_last_run)
                        {{ runtimeDate($customer->tenant_settings_cronjob_last_run) }} @ {{ \Carbon\Carbon::parse($customer->tenant_settings_cronjob_last_run)->format('H:i') }}
                    @else
                        ---
                    @endif
                </td>
            </tr>
            <tr>
                <td>@lang('lang.delivery_setting')</td>
                <td class="font-medium w-30">
                    @if($customer->tenant_settings_email_services == 'smtp')
                        @lang('lang.own_smtp_server')
                    @elseif($customer->tenant_settings_email_services == 'local')
                        @lang('lang.crm_mail_server')
                    @else
                        ---
                    @endif
                </td>
            </tr>
            <tr>
                <td>@lang('lang.email_queued')</td>
                <td class="font-medium w-30">{{ $customer->tenant_usage_count_emails_queued ?? 0 }}</td>
            </tr>
            <tr>
                <td>@lang('lang.email_processing')</td>
                <td class="font-medium w-30">{{ $customer->tenant_usage_count_emails_processing ?? 0 }}</td>
            </tr>
            <tr>
                <td>@lang('lang.email_sent')</td>
                <td class="font-medium w-30">{{ $customer->tenant_usage_count_emails_sent ?? 0 }}</td>
            </tr>
        </tbody>
    </table>

    <div class="line m-t-20 m-b-30"></div>

    <!--usage stats (counts)-->
    <div class="x-heading font-weight-bold">@lang('lang.usage_counts')</div>
    <table class="table no-border">
        <tbody>
            <tr>
                <td>@lang('lang.team')</td>
                <td class="font-medium w-30">{{ $customer->tenant_usage_count_team ?? 0 }}</td>
            </tr>
            <tr>
                <td>@lang('lang.clients')</td>
                <td class="font-medium w-30">{{ $customer->tenant_usage_count_clients ?? 0 }}</td>
            </tr>
            <tr>
                <td>@lang('lang.projects')</td>
                <td class="font-medium w-30">{{ $customer->tenant_usage_count_projects ?? 0 }}</td>
            </tr>
            <tr>
                <td>@lang('lang.tasks')</td>
                <td class="font-medium w-30">{{ $customer->tenant_usage_count_tasks ?? 0 }}</td>
            </tr>
            <tr>
                <td>@lang('lang.leads')</td>
                <td class="font-medium w-30">{{ $customer->tenant_usage_count_leads ?? 0 }}</td>
            </tr>
            <tr>
                <td>@lang('lang.invoices')</td>
                <td class="font-medium w-30">{{ $customer->tenant_usage_count_invoices ?? 0 }}</td>
            </tr>
            <tr>
                <td>@lang('lang.estimates')</td>
                <td class="font-medium w-30">{{ $customer->tenant_usage_count_estimates ?? 0 }}</td>
            </tr>
            <tr>
                <td>@lang('lang.proposals')</td>
                <td class="font-medium w-30">{{ $customer->tenant_usage_count_proposals ?? 0 }}</td>
            </tr>
            <tr>
                <td>@lang('lang.contracts')</td>
                <td class="font-medium w-30">{{ $customer->tenant_usage_count_contracts ?? 0 }}</td>
            </tr>
            <tr>
                <td>@lang('lang.tickets')</td>
                <td class="font-medium w-30">{{ $customer->tenant_usage_count_tickets ?? 0 }}</td>
            </tr>
        </tbody>
    </table>

    <div class="line m-t-20 m-b-30"></div>

    <!--platform value-->
    <div class="x-heading font-weight-bold">@lang('lang.platform_value')</div>
    <table class="table no-border">
        <tbody>
            <tr>
                <td>@lang('lang.paid_invoices')</td>
                <td class="font-medium w-30">{{ tenantMoneyFormat($customer->tenant_usage_value_invoices ?? 0, $customer) }}</td>
            </tr>
            <tr>
                <td>@lang('lang.accepted_estimates')</td>
                <td class="font-medium w-30">{{ tenantMoneyFormat($customer->tenant_usage_value_estimates ?? 0, $customer) }}</td>
            </tr>
            <tr>
                <td>@lang('lang.payments')</td>
                <td class="font-medium w-30">{{ tenantMoneyFormat($customer->tenant_usage_value_payments ?? 0, $customer) }}</td>
            </tr>
            <tr>
                <td>@lang('lang.accepted_proposals')</td>
                <td class="font-medium w-30">{{ tenantMoneyFormat($customer->tenant_usage_value_proposals ?? 0, $customer) }}</td>
            </tr>
            <tr>
                <td>@lang('lang.active_contracts')</td>
                <td class="font-medium w-30">{{ tenantMoneyFormat($customer->tenant_usage_value_contracts ?? 0, $customer) }}</td>
            </tr>
            <tr>
                <td>@lang('lang.converted_leads')</td>
                <td class="font-medium w-30">{{ tenantMoneyFormat($customer->tenant_usage_value_leads_converted ?? 0, $customer) }}</td>
            </tr>
        </tbody>
    </table>

</div>
