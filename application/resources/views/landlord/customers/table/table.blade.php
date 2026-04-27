<div class="card count-{{ @count($customers) }}" id="customer-table-wrapper">
    <div class="card-body">
        <div class="table-responsive list-table-wrapper">
            @if (@count($customers) > 0)
            <table id="customer-list-table" class="table m-t-0 m-b-0 table-hover no-wrap tenant-list"
                data-page-size="10">
                <thead>
                    <tr>
                        <!--tableconfig_column_1 [tenant_id]-->
                        <th class="tenants_col_tableconfig_column_1 {{ config('table.tableconfig_column_1') }} tableconfig_column_1">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_id" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_id&sortorder=asc') }}">@lang('lang.id')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_2 [tenant_name]-->
                        <th class="tenants_col_tableconfig_column_2 {{ config('table.tableconfig_column_2') }} tableconfig_column_2">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_name" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_name&sortorder=asc') }}">@lang('lang.name')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_3 [tenant_created]-->
                        <th class="tenants_col_tableconfig_column_3 {{ config('table.tableconfig_column_3') }} tableconfig_column_3">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_created" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_created&sortorder=asc') }}">@lang('lang.created')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_4 [domain]-->
                        <th class="tenants_col_tableconfig_column_4 {{ config('table.tableconfig_column_4') }} tableconfig_column_4">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_domain" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=domain&sortorder=asc') }}">@lang('lang.account_url')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_5 [last_seen]-->
                        <th class="tenants_col_tableconfig_column_5 {{ config('table.tableconfig_column_5') }} tableconfig_column_5">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_tracking_activity_last_seen" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_tracking_activity_last_seen&sortorder=asc') }}">@lang('lang.last_seen')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_6 [activity_status]-->
                        <th class="tenants_col_tableconfig_column_6 {{ config('table.tableconfig_column_6') }} tableconfig_column_6">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_activity_status" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_activity_status&sortorder=asc') }}">@lang('lang.activity')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_7 [package_name]-->
                        <th class="tenants_col_tableconfig_column_7 {{ config('table.tableconfig_column_7') }} tableconfig_column_7">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_package_name" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=package_name&sortorder=asc') }}">@lang('lang.package')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_8 [tenant_package_type]-->
                        <th class="tenants_col_tableconfig_column_8 {{ config('table.tableconfig_column_8') }} tableconfig_column_8">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_package_type" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_package_type&sortorder=asc') }}">@lang('lang.type')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_9 [tenant_status]-->
                        <th class="tenants_col_tableconfig_column_9 {{ config('table.tableconfig_column_9') }} tableconfig_column_9">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_status" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_status&sortorder=asc') }}">@lang('lang.status')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_26 [tenant_country]-->
                        <th class="tenants_col_tableconfig_column_26 {{ config('table.tableconfig_column_26') }} tableconfig_column_26">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_country" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_country&sortorder=asc') }}">@lang('lang.country')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_27 [tenant_telephone]-->
                        <th class="tenants_col_tableconfig_column_27 {{ config('table.tableconfig_column_27') }} tableconfig_column_27">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_telephone" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_telephone&sortorder=asc') }}">@lang('lang.telephone')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        @if(config('visibility.customer_tab_platform_usage'))
                        <!--tableconfig_column_10 [tenant_usage_count_team]-->
                        <th class="tenants_col_tableconfig_column_10 {{ config('table.tableconfig_column_10') }} tableconfig_column_10">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_usage_count_team" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_usage_count_team&sortorder=asc') }}">@lang('lang.team')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_11 [tenant_usage_count_clients]-->
                        <th class="tenants_col_tableconfig_column_11 {{ config('table.tableconfig_column_11') }} tableconfig_column_11">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_usage_count_clients" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_usage_count_clients&sortorder=asc') }}">@lang('lang.clients')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_12 [tenant_usage_count_projects]-->
                        <th class="tenants_col_tableconfig_column_12 {{ config('table.tableconfig_column_12') }} tableconfig_column_12">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_usage_count_projects" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_usage_count_projects&sortorder=asc') }}">@lang('lang.projects')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_13 [tenant_usage_count_tasks]-->
                        <th class="tenants_col_tableconfig_column_13 {{ config('table.tableconfig_column_13') }} tableconfig_column_13">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_usage_count_tasks" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_usage_count_tasks&sortorder=asc') }}">@lang('lang.tasks')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_14 [tenant_usage_count_leads]-->
                        <th class="tenants_col_tableconfig_column_14 {{ config('table.tableconfig_column_14') }} tableconfig_column_14">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_usage_count_leads" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_usage_count_leads&sortorder=asc') }}">@lang('lang.leads')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_15 [tenant_usage_count_invoices]-->
                        <th class="tenants_col_tableconfig_column_15 {{ config('table.tableconfig_column_15') }} tableconfig_column_15">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_usage_count_invoices" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_usage_count_invoices&sortorder=asc') }}">@lang('lang.invoices')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_16 [tenant_usage_count_estimates]-->
                        <th class="tenants_col_tableconfig_column_16 {{ config('table.tableconfig_column_16') }} tableconfig_column_16">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_usage_count_estimates" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_usage_count_estimates&sortorder=asc') }}">@lang('lang.estimates')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_17 [tenant_usage_count_proposals]-->
                        <th class="tenants_col_tableconfig_column_17 {{ config('table.tableconfig_column_17') }} tableconfig_column_17">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_usage_count_proposals" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_usage_count_proposals&sortorder=asc') }}">@lang('lang.proposals')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_18 [tenant_usage_count_contracts]-->
                        <th class="tenants_col_tableconfig_column_18 {{ config('table.tableconfig_column_18') }} tableconfig_column_18">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_usage_count_contracts" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_usage_count_contracts&sortorder=asc') }}">@lang('lang.contracts')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_19 [tenant_usage_count_tickets]-->
                        <th class="tenants_col_tableconfig_column_19 {{ config('table.tableconfig_column_19') }} tableconfig_column_19">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_usage_count_tickets" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_usage_count_tickets&sortorder=asc') }}">@lang('lang.tickets')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_20 [tenant_usage_count_emails_queued]-->
                        <th class="tenants_col_tableconfig_column_20 {{ config('table.tableconfig_column_20') }} tableconfig_column_20">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_usage_count_emails_queued" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_usage_count_emails_queued&sortorder=asc') }}">@lang('lang.queued')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_21 [tenant_usage_count_emails_sent]-->
                        <th class="tenants_col_tableconfig_column_21 {{ config('table.tableconfig_column_21') }} tableconfig_column_21">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_usage_count_emails_sent" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_usage_count_emails_sent&sortorder=asc') }}">@lang('lang.sent')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_22 [tenant_usage_count_emails_processing]-->
                        <th class="tenants_col_tableconfig_column_22 {{ config('table.tableconfig_column_22') }} tableconfig_column_22">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_usage_count_emails_processing" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_usage_count_emails_processing&sortorder=asc') }}">@lang('lang.processing')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_23 [tenant_usage_value_invoices]-->
                        <th class="tenants_col_tableconfig_column_23 {{ config('table.tableconfig_column_23') }} tableconfig_column_23">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_usage_value_invoices" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_usage_value_invoices&sortorder=asc') }}">@lang('lang.paid_invoices')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_24 [tenant_usage_value_estimates]-->
                        <th class="tenants_col_tableconfig_column_24 {{ config('table.tableconfig_column_24') }} tableconfig_column_24">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_usage_value_estimates" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_usage_value_estimates&sortorder=asc') }}">@lang('lang.accepted_estimates')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_25 [tenant_usage_value_leads_converted]-->
                        <th class="tenants_col_tableconfig_column_25 {{ config('table.tableconfig_column_25') }} tableconfig_column_25">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_usage_value_leads_converted" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_usage_value_leads_converted&sortorder=asc') }}">@lang('lang.converted_leads')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_28 [tenant_usage_value_payments]-->
                        <th class="tenants_col_tableconfig_column_28 {{ config('table.tableconfig_column_28') }} tableconfig_column_28">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_usage_value_payments" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_usage_value_payments&sortorder=asc') }}">@lang('lang.payments')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_29 [tenant_usage_value_proposals]-->
                        <th class="tenants_col_tableconfig_column_29 {{ config('table.tableconfig_column_29') }} tableconfig_column_29">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_usage_value_proposals" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_usage_value_proposals&sortorder=asc') }}">@lang('lang.accepted_proposals')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--tableconfig_column_30 [tenant_usage_value_contracts]-->
                        <th class="tenants_col_tableconfig_column_30 {{ config('table.tableconfig_column_30') }} tableconfig_column_30">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_tenant_usage_value_contracts" href="javascript:void(0)"
                                data-url="{{ urlResource('/app-admin/customers?action=sort&orderby=tenant_usage_value_contracts&sortorder=asc') }}">@lang('lang.active_contracts')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        @endif
                        <!--actions-->
                        <th class="tenants_col_action with-table-config-icon actions_column"><a href="javascript:void(0)">@lang('lang.action')</a>

                            <!--[tableconfig]-->
                            <div class="table-config-icon">
                                <span class="text-default js-toggle-table-config-panel"
                                    data-target="table-config-customers">
                                    <i class="sl-icon-settings"></i>
                                </span>
                            </div>

                        </th>
                    </tr>
                </thead>
                <tbody id="customer-td-container">
                    <!--ajax content here-->
                    @include('landlord.customers.table.ajax')
                    <!--ajax content here-->
                </tbody>
                <tbody class="border-0">
                    <tr>
                        <td colspan="28">
                            <!--load more button-->
                            @include('misc.load-more-button')
                            <!--load more button-->
                        </td>
                    </tr>
                </tbody>
            </table>
            @endif @if (@count($customers) == 0)
            <!--nothing found-->
            @include('notifications.no-results-found')
            <!--nothing found-->
            @endif
        </div>
    </div>
</div>