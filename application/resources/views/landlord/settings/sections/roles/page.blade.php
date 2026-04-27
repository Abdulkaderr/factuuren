@extends('landlord.settings.wrapper')
@section('settings_content')

<!--roles settings form-->
<div class="card">
    <div class="card-body" id="roles-settings-form">

        <!--permissions table-->
        <div class="table-responsive">
            <table class="table border text-nowrap mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="w-25">@lang('lang.permissions')</th>
                        <th class="w-25">@lang('lang.admin')</th>
                        <th class="w-25">@lang('lang.manager')</th>
                        <th class="w-25">@lang('lang.staff')</th>
                    </tr>
                </thead>
                <tbody>

                    <!--customers-->
                    <tr>
                        <td>@lang('lang.customers')</td>
                        <td>
                            <select class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $admin_role->role_permissions_customers ?? 'none' }}" disabled>
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="manager[role_permissions_customers]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $manager_role->role_permissions_customers ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="staff[role_permissions_customers]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $staff_role->role_permissions_customers ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                    </tr>

                    <!--plans-->
                    <tr>
                        <td>@lang('lang.plans')</td>
                        <td>
                            <select class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $admin_role->role_permissions_plans ?? 'none' }}" disabled>
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="manager[role_permissions_plans]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $manager_role->role_permissions_plans ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="staff[role_permissions_plans]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $staff_role->role_permissions_plans ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                    </tr>

                    <!--subscriptions-->
                    <tr>
                        <td>@lang('lang.subscriptions')</td>
                        <td>
                            <select class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $admin_role->role_permissions_subscriptions ?? 'none' }}" disabled>
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="manager[role_permissions_subscriptions]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $manager_role->role_permissions_subscriptions ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="staff[role_permissions_subscriptions]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $staff_role->role_permissions_subscriptions ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                    </tr>

                    <!--payments-->
                    <tr>
                        <td>@lang('lang.payments')</td>
                        <td>
                            <select class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $admin_role->role_permissions_payments ?? 'none' }}" disabled>
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="manager[role_permissions_payments]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $manager_role->role_permissions_payments ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="staff[role_permissions_payments]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $staff_role->role_permissions_payments ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                    </tr>

                    <!--global events-->
                    <tr>
                        <td>@lang('lang.global_events')</td>
                        <td>
                            <select class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $admin_role->role_permissions_global_events ?? 'none' }}" disabled>
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="manager[role_permissions_global_events]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $manager_role->role_permissions_global_events ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="staff[role_permissions_global_events]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $staff_role->role_permissions_global_events ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                    </tr>

                    <!--customer events-->
                    <tr>
                        <td>@lang('lang.customer_events')</td>
                        <td>
                            <select class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $admin_role->role_permissions_customer_events ?? 'none' }}" disabled>
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="manager[role_permissions_customer_events]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $manager_role->role_permissions_customer_events ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="staff[role_permissions_customer_events]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $staff_role->role_permissions_customer_events ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                    </tr>

                    <!--customer notes-->
                    <tr>
                        <td>@lang('lang.customer_notes')</td>
                        <td>
                            <select class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $admin_role->role_permissions_customer_notes ?? 'none' }}" disabled>
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="manager[role_permissions_customer_notes]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $manager_role->role_permissions_customer_notes ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="staff[role_permissions_customer_notes]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $staff_role->role_permissions_customer_notes ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                    </tr>

                    <!--customer subscription-->
                    <tr>
                        <td>@lang('lang.customer_subscription')</td>
                        <td>
                            <select class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $admin_role->role_permissions_customer_subscription ?? 'none' }}" disabled>
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="manager[role_permissions_customer_subscription]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $manager_role->role_permissions_customer_subscription ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="staff[role_permissions_customer_subscription]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $staff_role->role_permissions_customer_subscription ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                    </tr>

                    <!--customer payments-->
                    <tr>
                        <td>@lang('lang.customer_payments')</td>
                        <td>
                            <select class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $admin_role->role_permissions_customer_payments ?? 'none' }}" disabled>
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="manager[role_permissions_customer_payments]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $manager_role->role_permissions_customer_payments ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="staff[role_permissions_customer_payments]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $staff_role->role_permissions_customer_payments ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                    </tr>

                    <!--customer platform usage-->
                    <tr>
                        <td>@lang('lang.customer_platform_usage')</td>
                        <td>
                            <select class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $admin_role->role_permissions_customer_platform_usage ?? 'none' }}" disabled>
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="manager[role_permissions_customer_platform_usage]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $manager_role->role_permissions_customer_platform_usage ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="staff[role_permissions_customer_platform_usage]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $staff_role->role_permissions_customer_platform_usage ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                    </tr>

                    <!--team-->
                    <tr>
                        <td>@lang('lang.team')</td>
                        <td>
                            <select class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $admin_role->role_permissions_team ?? 'none' }}" disabled>
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="manager[role_permissions_team]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $manager_role->role_permissions_team ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="staff[role_permissions_team]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $staff_role->role_permissions_team ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                    </tr>

                    <!--resellers-->
                    <tr id="roles-resellers" class="hidden">
                        <td>@lang('lang.resellers')</td>
                        <td>
                            <select class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $admin_role->role_permissions_resellers ?? 'none' }}" disabled>
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="manager[role_permissions_resellers]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $manager_role->role_permissions_resellers ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="staff[role_permissions_resellers]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $staff_role->role_permissions_resellers ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                    </tr>

                    <!--settings-->
                    <tr id="roles-settings" class="hidden">
                        <td>@lang('lang.settings')</td>
                        <td>
                            <select class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $admin_role->role_permissions_settings ?? 'none' }}" disabled>
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="manager[role_permissions_settings]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $manager_role->role_permissions_settings ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                        <td>
                            <select name="staff[role_permissions_settings]" class="select2-basic form-control form-control-sm select2-preselected" data-width="element"
                                data-preselected="{{ $staff_role->role_permissions_settings ?? 'none' }}">
                                <option></option>
                                <option value="none">@lang('lang.none')</option>
                                <option value="view">@lang('lang.view')</option>
                                <option value="manage">@lang('lang.manage')</option>
                            </select>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <!--permissions table-->

        <!--submit-->
        <div class="text-right p-t-20">
            <button type="button"
                class="btn btn-danger waves-effect ajax-request"
                data-url="{{ url('app-admin/settings/roles') }}"
                data-type="form"
                data-form-id="roles-settings-form"
                data-ajax-type="POST"
                data-loading-target="body"
                data-on-start-submit-button="disable">
                @lang('lang.save_changes')
            </button>
        </div>
        <!--submit-->

    </div>
</div>
<!--roles settings form-->

@endsection
