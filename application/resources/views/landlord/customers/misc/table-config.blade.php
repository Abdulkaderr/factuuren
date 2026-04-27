<!-- right-sidebar -->
<div class="right-sidebar" id="table-config-customers">
    <form id="table-config-form-customers">
        <div class="slimscrollright">
            <div class="rpanel-title">
                <i class="icon-Filter-2"></i>{{ cleanLang(__('lang.table_settings')) }}
                <span>
                    <i class="ti-close js-close-side-panels" data-target="table-config-customers"></i>
                </span>
            </div>

            <!--set ajax url on parent container-->
            <div class="r-panel-body table-config-ajax" data-url="{{ url('app-admin/preferences/tables') }}" data-type="form"
                data-form-id="table-config-form-customers" data-ajax-type="post" data-progress-bar="hidden">

                <!-- ============================================================== -->
                <!-- SECTION 1 — Account Details                                    -->
                <!-- ============================================================== -->
                <p class="font-medium font-13 m-b-5 m-t-5">{{ cleanLang(__('lang.account_details')) }}</p>
                <hr class="m-t-0 m-b-10">

                <!--tableconfig_column_1 [id]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_1" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_1')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.id')</span>
                    </label>
                </div>

                <!--tableconfig_column_2 [name]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_2" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_2')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.name')</span>
                    </label>
                </div>

                <!--tableconfig_column_3 [created]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_3" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_3')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.created')</span>
                    </label>
                </div>

                <!--tableconfig_column_4 [account url]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_4" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_4')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.account_url')</span>
                    </label>
                </div>

                <!--tableconfig_column_5 [last seen]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_5" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_5')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.last_seen')</span>
                    </label>
                </div>

                <!--tableconfig_column_6 [activity]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_6" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_6')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.activity')</span>
                    </label>
                </div>

                <!--tableconfig_column_7 [package]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_7" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_7')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.package')</span>
                    </label>
                </div>

                <!--tableconfig_column_8 [type]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_8" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_8')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.type')</span>
                    </label>
                </div>

                <!--tableconfig_column_9 [status]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_9" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_9')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.status')</span>
                    </label>
                </div>

                <!--tableconfig_column_26 [country]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_26" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_26')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.country')</span>
                    </label>
                </div>

                <!--tableconfig_column_27 [telephone]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_27" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_27')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.telephone')</span>
                    </label>
                </div>

                @if(config('visibility.customer_tab_platform_usage'))
                <!-- ============================================================== -->
                <!-- SECTION 2 — Usage Counts                                       -->
                <!-- ============================================================== -->
                <p class="font-medium font-13 m-b-5 m-t-15">{{ cleanLang(__('lang.usage_counts')) }}</p>
                <hr class="m-t-0 m-b-10">

                <!--tableconfig_column_10 [team]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_10" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_10')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.team')</span>
                    </label>
                </div>

                <!--tableconfig_column_11 [clients]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_11" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_11')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.clients')</span>
                    </label>
                </div>

                <!--tableconfig_column_12 [projects]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_12" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_12')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.projects')</span>
                    </label>
                </div>

                <!--tableconfig_column_13 [tasks]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_13" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_13')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.tasks')</span>
                    </label>
                </div>

                <!--tableconfig_column_14 [leads]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_14" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_14')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.leads')</span>
                    </label>
                </div>

                <!--tableconfig_column_15 [invoices]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_15" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_15')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.invoices')</span>
                    </label>
                </div>

                <!--tableconfig_column_16 [estimates]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_16" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_16')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.estimates')</span>
                    </label>
                </div>

                <!--tableconfig_column_17 [proposals]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_17" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_17')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.proposals')</span>
                    </label>
                </div>

                <!--tableconfig_column_18 [contracts]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_18" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_18')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.contracts')</span>
                    </label>
                </div>

                <!--tableconfig_column_19 [tickets]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_19" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_19')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.tickets')</span>
                    </label>
                </div>

                <!--tableconfig_column_20 [emails queued]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_20" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_20')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.email_queued')</span>
                    </label>
                </div>

                <!--tableconfig_column_21 [emails sent]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_21" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_21')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.email_sent')</span>
                    </label>
                </div>

                <!--tableconfig_column_22 [emails processing]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_22" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_22')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.email_processing')</span>
                    </label>
                </div>

                <!-- ============================================================== -->
                <!-- SECTION 3 — Platform Value (Monetary)                          -->
                <!-- ============================================================== -->
                <p class="font-medium font-13 m-b-5 m-t-15">{{ cleanLang(__('lang.platform_value')) }}</p>
                <hr class="m-t-0 m-b-10">

                <!--tableconfig_column_23 [invoice value]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_23" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_23')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.paid_invoices')</span>
                    </label>
                </div>

                <!--tableconfig_column_24 [estimate value]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_24" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_24')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.accepted_estimates')</span>
                    </label>
                </div>

                <!--tableconfig_column_25 [leads converted value]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_25" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_25')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.converted_leads')</span>
                    </label>
                </div>

                <!--tableconfig_column_28 [payments value]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_28" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_28')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.payments')</span>
                    </label>
                </div>

                <!--tableconfig_column_29 [proposals value]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_29" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_29')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.accepted_proposals')</span>
                    </label>
                </div>

                <!--tableconfig_column_30 [contracts value]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_30" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_30')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.active_contracts')</span>
                    </label>
                </div>
                @endif

            </div>

            <!--table name-->
            <input type="hidden" name="tableconfig_table_name" value="customers">

            <!--buttons-->
            <div class="buttons-block">
                <button type="button" name="foo1" class="btn btn-rounded-x btn-secondary js-close-side-panels"
                    data-target="table-config-customers">{{ cleanLang(__('lang.close')) }}</button>
                <input type="hidden" name="action" value="search">
            </div>
        </div>
        <!--body-->
</div>
</form>
</div>
<!--sidebar-->
