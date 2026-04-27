<div class="p-t-10 p-b-10">

    <!--top bar: log type filter dropdown (top right)-->
    <div class="form-group row">
        <div class="col-6 text-left">
        </div>
        <div class="col-6 text-left">
            <select class="select2-basic form-control form-control-sm d-inline-block" id="selectErrorLogType"
                data-url="" data-loading-target="error-logs-table-wrapper">
                <option value="0">@lang('lang.select_log_type')</option>
                <option
                    value="{{ url('app-admin/customers/'.$customer->tenant_id.'/error-logs?log_type=email-delivery-error') }}">
                    @lang('lang.email_delivery_errors')
                </option>
                <option value="{{ url('app-admin/customers/'.$customer->tenant_id.'/error-logs?log_type=all') }}">
                    @lang('lang.all_types')
                </option>
            </select>
        </div>
    </div>


    <!--table area: replaced each time a log type is selected-->
    <div id="error-logs-table-wrapper">

        <!--welcome message shown before a log type is selected-->
        <div class="row">
            <div class="col-12">
                <div class="page-notification-imaged p-t-60">
                    <img src="{{ url('/') }}/public/images/search-icon.png" class="w-px-200" alt="Error Logs" />
                    <div class="message p-t-10">
                        <h5>@lang('lang.select_log_type_from_dropdown')</h5>
                    </div>
                </div>
            </div>
        </div>
        <!--/welcome message-->

    </div>

    <!--delete all logs button (bottom right)-->
    <div class="m-t-20 text-right hidden" id="error-logs-delete-all-button">
        <a href="javascript:void(0);" class="btn btn-danger confirm-action-danger"
            data-confirm-title="@lang('lang.delete_all')" data-confirm-text="@lang('lang.are_you_sure')"
            data-url="{{ url('app-admin/customers/'.$customer->tenant_id.'/error-logs') }}" data-ajax-type="DELETE">
            @lang('lang.delete_all')
        </a>
    </div>

</div>