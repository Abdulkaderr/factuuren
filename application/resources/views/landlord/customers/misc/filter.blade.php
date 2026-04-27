<!-- right-sidebar -->
<div class="right-sidebar" id="sidepanel-filter-customers">
    <form>
        <div class="slimscrollright">
            <!--title-->
            <div class="rpanel-title">
                <i class="icon-Filter-2"></i>@lang('lang.filter_customers')
                <span>
                    <i class="ti-close js-close-side-panels" data-target="sidepanel-filter-customers"></i>
                </span>
            </div>

            <!--body-->
            <div class="r-panel-body">

                <!--activity status-->
                <div class="filter-block">
                    <div class="title">
                        @lang('lang.activity_status')
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <select name="filter_tenant_activity_status" id="filter_tenant_activity_status"
                                    class="form-control form-control-sm select2-basic select2-preselected"
                                    data-preselected="{{ request('filter_tenant_activity_status') ?? '' }}"
                                    data-width="100%">
                                    <option value=""></option>
                                    <option value="active">@lang('lang.active') - 7 @lang('lang.days')</option>
                                    <option value="dormant">@lang('lang.dormant') - 8-30 @lang('lang.days')</option>
                                    <option value="inactive">@lang('lang.inactive') - 30+ @lang('lang.days')</option>
                                    <option value="none">@lang('lang.none')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!--country-->
                <div class="filter-block">
                    <div class="title">
                        @lang('lang.country')
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <select name="filter_tenant_country" id="filter_tenant_country"
                                    class="form-control form-control-sm select2-basic-with-search select2-preselected"
                                    data-preselected="{{ request('filter_tenant_country') ?? '' }}"
                                    data-width="100%">
                                    <option value=""></option>
                                    @include('misc.country-list')
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!--subscription & account section-->
                <hr>
                <div class="spacer row">
                    <div class="col-sm-12 col-lg-8">
                        <span class="title">@lang('lang.subscription')</span>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="switch  text-right">
                            <label>
                                <input type="checkbox" name="toggle_subscription" id="toggle_subscription"
                                    class="js-switch-toggle-hidden-content" data-target="toggle_subscription_content">
                                <span class="lever switch-col-light-blue"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="hidden p-t-10" id="toggle_subscription_content">

                    <!--filter: plan-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.plan')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_plan" id="filter_tenant_plan"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_plan') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        @foreach($packages as $package)
                                        <option value="{{ $package->package_id }}">{{ $package->package_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: subscription type-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.subscription_type')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_subscription_type" id="filter_tenant_subscription_type"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_subscription_type') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="free">@lang('lang.free')</option>
                                        <option value="paid">@lang('lang.paid')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: account status-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.account_status')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_status" id="filter_tenant_status"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_status') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="unsubscribed">@lang('lang.unsubscribed')</option>
                                        <option value="free-trial">@lang('lang.free_trial')</option>
                                        <option value="awaiting-payment">@lang('lang.awaiting_payment')</option>
                                        <option value="failed">@lang('lang.failed')</option>
                                        <option value="active">@lang('lang.active')</option>
                                        <option value="cancelled">@lang('lang.cancelled')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: free trial-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.free_trial')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_free_trial" id="filter_tenant_free_trial"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_free_trial') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: signup period-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.signup_period')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_signup_period" id="filter_tenant_signup_period"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_signup_period') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="today">@lang('lang.today')</option>
                                        <option value="yesterday">@lang('lang.yesterday')</option>
                                        <option value="this_week">@lang('lang.this_week')</option>
                                        <option value="last_week">@lang('lang.last_week')</option>
                                        <option value="this_month">@lang('lang.this_month')</option>
                                        <option value="last_month">@lang('lang.last_month')</option>
                                        <option value="this_year">@lang('lang.this_year')</option>
                                        <option value="last_year">@lang('lang.last_year')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: signup date range-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.signup_date')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="filter_tenant_signup_date_start"
                                        class="form-control form-control-sm pickadate" autocomplete="off"
                                        placeholder="@lang('lang.from')"
                                        value="{{ runtimeDatepickerDate(request('filter_tenant_signup_date_start') ?? '') }}">
                                    <input class="mysql-date" type="hidden"
                                        name="filter_tenant_signup_date_start" id="filter_tenant_signup_date_start"
                                        value="{{ request('filter_tenant_signup_date_start') ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="filter_tenant_signup_date_end"
                                        class="form-control form-control-sm pickadate" autocomplete="off"
                                        placeholder="@lang('lang.to')"
                                        value="{{ runtimeDatepickerDate(request('filter_tenant_signup_date_end') ?? '') }}">
                                    <input class="mysql-date" type="hidden"
                                        name="filter_tenant_signup_date_end" id="filter_tenant_signup_date_end"
                                        value="{{ request('filter_tenant_signup_date_end') ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                @if(config('visibility.customer_tab_platform_usage'))
                <!--platform usage section-->
                <hr>
                <div class="spacer row">
                    <div class="col-sm-12 col-lg-8">
                        <span class="title">@lang('lang.platform_usage')</span>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="switch  text-right">
                            <label>
                                <input type="checkbox" name="toggle_platform_usage" id="toggle_platform_usage"
                                    class="js-switch-toggle-hidden-content" data-target="toggle_platform_usage_content">
                                <span class="lever switch-col-light-blue"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="hidden p-t-10" id="toggle_platform_usage_content">

                    <!--filter: has team members-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.team')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_usage_count_team" id="filter_tenant_usage_count_team"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_usage_count_team') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: has clients-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.clients')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_usage_count_clients" id="filter_tenant_usage_count_clients"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_usage_count_clients') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: has projects-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.projects')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_usage_count_projects" id="filter_tenant_usage_count_projects"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_usage_count_projects') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: has tasks-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.tasks')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_usage_count_tasks" id="filter_tenant_usage_count_tasks"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_usage_count_tasks') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: has leads-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.leads')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_usage_count_leads" id="filter_tenant_usage_count_leads"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_usage_count_leads') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: has invoices-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.invoices')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_usage_count_invoices" id="filter_tenant_usage_count_invoices"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_usage_count_invoices') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: has estimates-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.estimates')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_usage_count_estimates" id="filter_tenant_usage_count_estimates"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_usage_count_estimates') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: has proposals-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.proposals')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_usage_count_proposals" id="filter_tenant_usage_count_proposals"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_usage_count_proposals') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: has contracts-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.contracts')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_usage_count_contracts" id="filter_tenant_usage_count_contracts"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_usage_count_contracts') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: has tickets-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.tickets')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_usage_count_tickets" id="filter_tenant_usage_count_tickets"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_usage_count_tickets') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: has queued emails-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.email_queued')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_usage_count_emails_queued" id="filter_tenant_usage_count_emails_queued"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_usage_count_emails_queued') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: has sent emails-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.email_sent')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_usage_count_emails_sent" id="filter_tenant_usage_count_emails_sent"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_usage_count_emails_sent') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: has processing emails-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.email_processing')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_usage_count_emails_processing" id="filter_tenant_usage_count_emails_processing"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_usage_count_emails_processing') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!--platform value section-->
                <hr>
                <div class="spacer row">
                    <div class="col-sm-12 col-lg-8">
                        <span class="title">@lang('lang.platform_value')</span>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="switch  text-right">
                            <label>
                                <input type="checkbox" name="toggle_platform_value" id="toggle_platform_value"
                                    class="js-switch-toggle-hidden-content" data-target="toggle_platform_value_content">
                                <span class="lever switch-col-light-blue"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="hidden p-t-10" id="toggle_platform_value_content">

                    <!--filter: has invoice value-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.paid_invoices')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_usage_value_invoices" id="filter_tenant_usage_value_invoices"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_usage_value_invoices') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: has estimate value-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.accepted_estimates')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_usage_value_estimates" id="filter_tenant_usage_value_estimates"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_usage_value_estimates') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: has leads converted value-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.converted_leads')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_usage_value_leads_converted" id="filter_tenant_usage_value_leads_converted"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_usage_value_leads_converted') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: has payments value-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.payments')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_usage_value_payments" id="filter_tenant_usage_value_payments"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_usage_value_payments') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: has proposals value-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.accepted_proposals')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_usage_value_proposals" id="filter_tenant_usage_value_proposals"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_usage_value_proposals') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--filter: has contracts value-->
                    <div class="filter-block">
                        <div class="title">@lang('lang.active_contracts')</div>
                        <div class="fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <select name="filter_tenant_usage_value_contracts" id="filter_tenant_usage_value_contracts"
                                        class="form-control form-control-sm select2-basic select2-preselected"
                                        data-preselected="{{ request('filter_tenant_usage_value_contracts') ?? '' }}"
                                        data-width="100%">
                                        <option value=""></option>
                                        <option value="yes">@lang('lang.yes')</option>
                                        <option value="no">@lang('lang.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @endif

                <!--buttons-->
                <div class="buttons-block">
                    <a href="{{ url('/app-admin/customers') }}"
                        class="btn btn-rounded-x btn-secondary">@lang('lang.reset')</a>
                    <input type="hidden" name="action" value="search">
                    <button type="button" class="btn btn-rounded-x btn-danger js-ajax-ux-request apply-filter-button"
                        data-url="{{ url('/app-admin/customers/search') }}" data-type="form"
                        data-ajax-type="GET">@lang('lang.apply_filter')</button>
                </div>
            </div>
            <!--body-->
        </div>
    </form>
</div>
<!--sidebar-->
