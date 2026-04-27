@foreach($customers as $customer)
<!--each row-->
<tr id="customer_{{ $customer->tenant_id }}">
    <!--tableconfig_column_1 [tenant_id]-->
    <td class="tenants_col_tableconfig_column_1 {{ config('table.tableconfig_column_1') }} tableconfig_column_1"
        id="tenants_col_id_{{ $customer->tenant_id }}">
        {{ $customer->tenant_id }}
    </td>

    <!--tableconfig_column_2 [tenant_name]-->
    <td class="tenants_col_tableconfig_column_2 {{ config('table.tableconfig_column_2') }} tableconfig_column_2">
        <a href="{{ url('app-admin/customers/'.$customer->tenant_id) }}">{{ $customer->tenant_name }}</a>
    </td>

    <!--tableconfig_column_3 [tenant_created]-->
    <td class="tenants_col_tableconfig_column_3 {{ config('table.tableconfig_column_3') }} tableconfig_column_3">
        {{ runtimeDate($customer->tenant_created) }}
    </td>

    <!--tableconfig_column_4 [domain]-->
    <td class="tenants_col_tableconfig_column_4 {{ config('table.tableconfig_column_4') }} tableconfig_column_4">
        <a href="https://{{ $customer->domain }}" target="_blank">{{ $customer->domain }}</a>
    </td>

    <!--tableconfig_column_5 [last_seen]-->
    <td class="tenants_col_tableconfig_column_5 {{ config('table.tableconfig_column_5') }} tableconfig_column_5">
        @if($customer->tenant_tracking_activity_last_seen)
        {{ runtimeDate($customer->tenant_tracking_activity_last_seen) }} @ {{ \Carbon\Carbon::parse($customer->tenant_tracking_activity_last_seen)->format('H:i') }}
        @else
        ---
        @endif
    </td>

    <!--tableconfig_column_6 [activity_status]-->
    <td class="tenants_col_tableconfig_column_6 {{ config('table.tableconfig_column_6') }} tableconfig_column_6">
        @if($customer->tenant_activity_status == 'active')
        <span class="label label-light-success">@lang('lang.active')</span>
        @elseif($customer->tenant_activity_status == 'dormant')
        <span class="label label-light-warning">@lang('lang.dormant')</span>
        @elseif($customer->tenant_activity_status == 'inactive')
        <span class="label label-light-danger">@lang('lang.inactive')</span>
        @else
        <span class="label label-default">@lang('lang.none')</span>
        @endif
    </td>

    <!--tableconfig_column_7 [package_name]-->
    <td class="tenants_col_tableconfig_column_7 {{ config('table.tableconfig_column_7') }} tableconfig_column_7">
        <a href="{{ url('app-admin/packages?filter_package_id='.$customer->package_id) }}"
            target="_blank">{{ $customer->package_name ?? '---' }}</a>
    </td>

    <!--tableconfig_column_8 [tenant_package_type]-->
    <td class="tenants_col_tableconfig_column_8 {{ config('table.tableconfig_column_8') }} tableconfig_column_8">
        {{ runtimeLang($customer->subscription_type ?? '---') }}
    </td>

    <!--tableconfig_column_9 [tenant_status]-->
    <td class="tenants_col_tableconfig_column_9 {{ config('table.tableconfig_column_9') }} tableconfig_column_9">
        <span
            class="label {{ runtimeCustomerStatusColors($customer->tenant_status) }}">{{ runtimeCustomerStatusLang($customer->tenant_status) }}</span>
    </td>

    <!--tableconfig_column_26 [tenant_country]-->
    <td class="tenants_col_tableconfig_column_26 {{ config('table.tableconfig_column_26') }} tableconfig_column_26">{{ $customer->tenant_country ?? '---' }}</td>
    <!--tableconfig_column_27 [tenant_telephone]-->
    <td class="tenants_col_tableconfig_column_27 {{ config('table.tableconfig_column_27') }} tableconfig_column_27">{{ $customer->tenant_telephone ?? '---' }}</td>

    @if(config('visibility.customer_tab_platform_usage'))
    <!--tableconfig_column_10 [tenant_usage_count_team]-->
    <td class="tenants_col_tableconfig_column_10 {{ config('table.tableconfig_column_10') }} tableconfig_column_10">{{ $customer->tenant_usage_count_team ?? 0 }}</td>
    <!--tableconfig_column_11 [tenant_usage_count_clients]-->
    <td class="tenants_col_tableconfig_column_11 {{ config('table.tableconfig_column_11') }} tableconfig_column_11">{{ $customer->tenant_usage_count_clients ?? 0 }}</td>
    <!--tableconfig_column_12 [tenant_usage_count_projects]-->
    <td class="tenants_col_tableconfig_column_12 {{ config('table.tableconfig_column_12') }} tableconfig_column_12">{{ $customer->tenant_usage_count_projects ?? 0 }}</td>
    <!--tableconfig_column_13 [tenant_usage_count_tasks]-->
    <td class="tenants_col_tableconfig_column_13 {{ config('table.tableconfig_column_13') }} tableconfig_column_13">{{ $customer->tenant_usage_count_tasks ?? 0 }}</td>
    <!--tableconfig_column_14 [tenant_usage_count_leads]-->
    <td class="tenants_col_tableconfig_column_14 {{ config('table.tableconfig_column_14') }} tableconfig_column_14">{{ $customer->tenant_usage_count_leads ?? 0 }}</td>
    <!--tableconfig_column_15 [tenant_usage_count_invoices]-->
    <td class="tenants_col_tableconfig_column_15 {{ config('table.tableconfig_column_15') }} tableconfig_column_15">{{ $customer->tenant_usage_count_invoices ?? 0 }}</td>
    <!--tableconfig_column_16 [tenant_usage_count_estimates]-->
    <td class="tenants_col_tableconfig_column_16 {{ config('table.tableconfig_column_16') }} tableconfig_column_16">{{ $customer->tenant_usage_count_estimates ?? 0 }}</td>
    <!--tableconfig_column_17 [tenant_usage_count_proposals]-->
    <td class="tenants_col_tableconfig_column_17 {{ config('table.tableconfig_column_17') }} tableconfig_column_17">{{ $customer->tenant_usage_count_proposals ?? 0 }}</td>
    <!--tableconfig_column_18 [tenant_usage_count_contracts]-->
    <td class="tenants_col_tableconfig_column_18 {{ config('table.tableconfig_column_18') }} tableconfig_column_18">{{ $customer->tenant_usage_count_contracts ?? 0 }}</td>
    <!--tableconfig_column_19 [tenant_usage_count_tickets]-->
    <td class="tenants_col_tableconfig_column_19 {{ config('table.tableconfig_column_19') }} tableconfig_column_19">{{ $customer->tenant_usage_count_tickets ?? 0 }}</td>
    <!--tableconfig_column_20 [tenant_usage_count_emails_queued]-->
    <td class="tenants_col_tableconfig_column_20 {{ config('table.tableconfig_column_20') }} tableconfig_column_20">{{ $customer->tenant_usage_count_emails_queued ?? 0 }}</td>
    <!--tableconfig_column_21 [tenant_usage_count_emails_sent]-->
    <td class="tenants_col_tableconfig_column_21 {{ config('table.tableconfig_column_21') }} tableconfig_column_21">{{ $customer->tenant_usage_count_emails_sent ?? 0 }}</td>
    <!--tableconfig_column_22 [tenant_usage_count_emails_processing]-->
    <td class="tenants_col_tableconfig_column_22 {{ config('table.tableconfig_column_22') }} tableconfig_column_22">{{ $customer->tenant_usage_count_emails_processing ?? 0 }}</td>
    <!--tableconfig_column_23 [tenant_usage_value_invoices]-->
    <td class="tenants_col_tableconfig_column_23 {{ config('table.tableconfig_column_23') }} tableconfig_column_23">{{ tenantMoneyFormat($customer->tenant_usage_value_invoices ?? 0, $customer) }}</td>
    <!--tableconfig_column_24 [tenant_usage_value_estimates]-->
    <td class="tenants_col_tableconfig_column_24 {{ config('table.tableconfig_column_24') }} tableconfig_column_24">{{ tenantMoneyFormat($customer->tenant_usage_value_estimates ?? 0, $customer) }}</td>
    <!--tableconfig_column_25 [tenant_usage_value_leads_converted]-->
    <td class="tenants_col_tableconfig_column_25 {{ config('table.tableconfig_column_25') }} tableconfig_column_25">{{ tenantMoneyFormat($customer->tenant_usage_value_leads_converted ?? 0, $customer) }}</td>
    <!--tableconfig_column_28 [tenant_usage_value_payments]-->
    <td class="tenants_col_tableconfig_column_28 {{ config('table.tableconfig_column_28') }} tableconfig_column_28">{{ tenantMoneyFormat($customer->tenant_usage_value_payments ?? 0, $customer) }}</td>
    <!--tableconfig_column_29 [tenant_usage_value_proposals]-->
    <td class="tenants_col_tableconfig_column_29 {{ config('table.tableconfig_column_29') }} tableconfig_column_29">{{ tenantMoneyFormat($customer->tenant_usage_value_proposals ?? 0, $customer) }}</td>
    <!--tableconfig_column_30 [tenant_usage_value_contracts]-->
    <td class="tenants_col_tableconfig_column_30 {{ config('table.tableconfig_column_30') }} tableconfig_column_30">{{ tenantMoneyFormat($customer->tenant_usage_value_contracts ?? 0, $customer) }}</td>
    @endif

    <td class="tenants_col_action actions_column" id="tenants_col_action_{{ $customer->tenant_id }}">
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit">
            <!--delete-->
            @if(config('visibility.resource_management'))
            <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="{{ cleanLang(__('lang.delete_customer')) }}"
                data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="DELETE"
                data-url="{{ url('/app-admin') }}/customers/{{ $customer->tenant_id }}">
                <i class="sl-icon-trash"></i>
            </button>
            @endif
            <!--edit-->
            @if(config('visibility.resource_management'))
            <span class="list-table-action dropdown" style="font-size: inherit;">
                <button type="button" id="listTableAction" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false" class="btn btn-outline-default btn-circle btn-sm">
                    <i class="sl-icon-note"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="listTableAction">
                    <!--edit account-->
                    <a class="dropdown-item edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                        href="javascript:void(0)" data-toggle="modal" data-target="#commonModal"
                        data-modal-title="@lang('lang.edit_account')"
                        data-url="{{ urlResource('/app-admin/customers/'.$customer->tenant_id.'/edit') }}"
                        data-action-url="{{ urlResource('/app-admin/customers/'.$customer->tenant_id) }}"
                        data-loading-target="commonModalBody" data-action-method="PUT">
                        @lang('lang.edit_account')</a>

                    <!--update password-->
                    <a class="dropdown-item edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                        href="javascript:void(0)" data-toggle="modal" data-target="#commonModal"
                        data-modal-title="@lang('lang.update_password')"
                        data-url="{{ urlResource('/app-admin/customers/'.$customer->tenant_id.'/update-password?ref=list') }}"
                        data-action-url="{{ urlResource('/app-admin/customers/'.$customer->tenant_id.'/update-password?ref=list') }}"
                        data-loading-target="commonModalBody" data-action-method="POST">
                        @lang('lang.update_password')</a>
                </div>
            </span>
            @endif

            <!--login in as a customer-->
            @if(config('visibility.resource_management'))
            <a type="button" title="@lang('lang.login_in_as_customer')"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm" target="_blank"
                href="{{ urlResource('/app-admin/customers/'.$customer->tenant_id.'/login?ref=list') }}">
                <i class="sl-icon-people"></i>
            </a>
            @endif


            @if(!config('app.application_demo_mode'))
            @if($customer->tenant_email_config_type == 'local' && $customer->tenant_email_config_status == 'pending' && config('customer_defaults.defaults_email_delivery') == 'smtp_and_sendmail')
            <button type="button"
                class="email_settings_pending_{{ $customer->tenant_id }} btn btn-outline-info btn-circle btn-sm data-toggle-action-tooltip edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                title="{{ cleanLang(__('lang.mail_action_required')) }}" data-toggle="modal" data-target="#commonModal"
                data-url="{{ url('app-admin/customers/'.$customer->tenant_id.'/email?source=list') }}"
                data-loading-target="commonModalBody" data-footer-visibility="hidden" data-modal-size="modal-xl"
                data-modal-title="@lang('lang.mail_delivery_server')">
                <i class="ti-email"></i>
                <div class="notify email-blinking-icon-table"> <span class="heartbit"></span> <span
                        class="point"></span> </div>
            </button>
            @endif
            @endif



        </span>
        <!--action button-->
    </td>
</tr>
@endforeach
<!--each row-->