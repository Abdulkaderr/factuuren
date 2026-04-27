<!-- right-sidebar -->
<div class="right-sidebar" id="table-config-items">
    <form id="table-config-form">
        <div class="slimscrollright">
            <div class="rpanel-title">
                <i class="icon-Filter-2"></i>{{ cleanLang(__('lang.table_settings')) }}
                <span>
                    <i class="ti-close js-close-side-panels" data-target="table-config-items"></i>
                </span>
            </div>

            <!--set ajax url on parent container-->
            <div class="r-panel-body table-config-ajax" data-url="{{ url('preferences/tables') }}" data-type="form"
                data-form-id="table-config-form" data-ajax-type="post" data-progress-bar="hidden">

                <!--tableconfig_column_1 [title]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_1" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_1')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.title')</span>
                    </label>
                </div>

                <!--tableconfig_column_2 [rate]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_2" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_2')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.rate')</span>
                    </label>
                </div>

                <!--tableconfig_column_3 [unit]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_3" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_3')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.unit')</span>
                    </label>
                </div>

                <!--tableconfig_column_4 [category]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_4" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_4')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.category')</span>
                    </label>
                </div>

                <!--tableconfig_column_5 [number sold]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_5" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_5')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.number_sold')</span>
                    </label>
                </div>

                <!--tableconfig_column_6 [amount sold]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_6" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_6')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.amount_sold')</span>
                    </label>
                </div>

                <!--tableconfig_column_7 [description]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_7" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_7')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.description')</span>
                    </label>
                </div>

                <!--tableconfig_column_8 [tax status]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_8" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_8')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.tax_status')</span>
                    </label>
                </div>

                <!--tableconfig_column_9 [default tax]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_9" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            {{ runtimePrechecked(config('table.tableconfig_column_9')) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">@lang('lang.default_tax')</span>
                    </label>
                </div>

                <!--custom fields section-->
                @if(\App\Models\ProductCustomField::where('items_custom_field_status', 'enabled')->exists())
                <div class="p-t-20">
                    <h6 class="p-b-10">@lang('lang.custom_fields')</h6>

                    @foreach(\App\Models\ProductCustomField::where('items_custom_field_status', 'enabled')->get() as $customField)
                    <div class="p-b-5">
                        <label class="custom-control custom-checkbox table-config-checkbox-container">
                            <input name="tableconfig_column_{{ 9 + $customField->items_custom_id }}"
                                   type="checkbox"
                                   class="custom-control-input table-config-checkbox cursor-pointer"
                                   {{ runtimePrechecked(config('table.tableconfig_column_' . (9 + $customField->items_custom_id))) }}>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">{{ $customField->items_custom_field_name }}</span>
                        </label>
                    </div>
                    @endforeach
                </div>
                @endif

            </div>

            <!--table name-->
            <input type="hidden" name="tableconfig_table_name" value="items">

            <!--buttons-->
            <div class="buttons-block">
                <button type="button" name="foo1" class="btn btn-rounded-x btn-secondary js-close-side-panels"
                    data-target="table-config-items">{{ cleanLang(__('lang.close')) }}</button>
                <input type="hidden" name="action" value="search">
            </div>
        </div>
        <!--body-->
</div>
</form>
</div>
<!--sidebar-->
