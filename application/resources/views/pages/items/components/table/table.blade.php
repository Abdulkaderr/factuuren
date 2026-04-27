<div class="card count-{{ @count($items ?? []) }}" id="items-table-wrapper">
    <div class="card-body">
        <!--filtered results warning-->
        @if(config('filter.status') == 'active')
        <div class="filtered-results-warning opacity-8 p-b-5">
            <small>
                @lang('lang.these_results_are')
                <a href="javascript:void(0);" class="js-toggle-side-panel" data-target="sidepanel-filter-items">@lang('lang.filtered')</a>.
                @lang('lang.you_can')
                <a href="{{ url('/items?clear-filter=yes') }}">@lang('lang.clear_the_filters')</a>.
            </small>
        </div>
        @endif

        <div class="table-responsive list-table-wrapper">
            @if (@count($items ?? []) > 0)
            <table id="items-list-table" class="table m-t-0 m-b-0 table-hover no-wrap item-list" data-page-size="10">
                <thead>
                    <tr>
                        @if(config('visibility.items_col_checkboxes'))
                        <th class="list-checkbox-wrapper">
                            <!--list checkbox-->
                            <span class="list-checkboxes display-inline-block w-px-20">
                                <input type="checkbox" id="listcheckbox-items" name="listcheckbox-items"
                                    class="listcheckbox-all filled-in chk-col-light-blue"
                                    data-actions-container-class="items-checkbox-actions-container"
                                    data-children-checkbox-class="listcheckbox-items">
                                <label for="listcheckbox-items"></label>
                            </span>
                        </th>
                        @endif
                        <!--tableconfig_column_1 [title]-->
                        <th class="items_col_tableconfig_column_1 {{ config('table.tableconfig_column_1') }} tableconfig_column_1">
                            <a class="js-ajax-ux-request js-list-sorting"
                                id="sort_item_description" href="javascript:void(0)"
                                data-url="{{ urlResource('/items?action=sort&orderby=item_description&sortorder=asc') }}">{{ cleanLang(__('lang.title')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>

                        <!--tableconfig_column_2 [rate]-->
                        <th class="items_col_tableconfig_column_2 {{ config('table.tableconfig_column_2') }} tableconfig_column_2">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_item_rate"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/items?action=sort&orderby=item_rate&sortorder=asc') }}">{{ cleanLang(__('lang.rate')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>

                        <!--tableconfig_column_3 [unit]-->
                        <th class="items_col_tableconfig_column_3 {{ config('table.tableconfig_column_3') }} tableconfig_column_3">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_item_unit"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/items?action=sort&orderby=item_unit&sortorder=asc') }}">{{ cleanLang(__('lang.unit')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>

                        <!--tableconfig_column_4 [category]-->
                        <th class="items_col_tableconfig_column_4 {{ config('table.tableconfig_column_4') }} tableconfig_column_4">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_category"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/items?action=sort&orderby=category&sortorder=asc') }}">{{ cleanLang(__('lang.category')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>

                        <!--tableconfig_column_5 [number sold]-->
                        <th class="items_col_tableconfig_column_5 {{ config('table.tableconfig_column_5') }} tableconfig_column_5">
                            <a class="js-ajax-ux-request js-list-sorting"
                                id="sort_count_sold" href="javascript:void(0)"
                                data-url="{{ urlResource('/items?action=sort&orderby=count_sold&sortorder=asc') }}">@lang('lang.number_sold')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>

                        <!--tableconfig_column_6 [amount sold]-->
                        <th class="items_col_tableconfig_column_6 {{ config('table.tableconfig_column_6') }} tableconfig_column_6">
                            <a class="js-ajax-ux-request js-list-sorting"
                                id="sort_amount_sold" href="javascript:void(0)"
                                data-url="{{ urlResource('/items?action=sort&orderby=amount_sold&sortorder=asc') }}">@lang('lang.amount_sold')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>

                        <!--tableconfig_column_7 [description]-->
                        <th class="items_col_tableconfig_column_7 {{ config('table.tableconfig_column_7') }} tableconfig_column_7">
                            <a class="js-ajax-ux-request js-list-sorting"
                                id="sort_item_notes" href="javascript:void(0)"
                                data-url="{{ urlResource('/items?action=sort&orderby=item_notes&sortorder=asc') }}">@lang('lang.description')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>

                        <!--tableconfig_column_8 [tax status]-->
                        <th class="items_col_tableconfig_column_8 {{ config('table.tableconfig_column_8') }} tableconfig_column_8">
                            <a class="js-ajax-ux-request js-list-sorting"
                                id="sort_item_tax_status" href="javascript:void(0)"
                                data-url="{{ urlResource('/items?action=sort&orderby=item_tax_status&sortorder=asc') }}">@lang('lang.tax_status')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>

                        <!--tableconfig_column_9 [default tax]-->
                        <th class="items_col_tableconfig_column_9 {{ config('table.tableconfig_column_9') }} tableconfig_column_9">
                            <a href="javascript:void(0)">@lang('lang.default_tax')</a>
                        </th>

                        <!--tableconfig_column_10 [custom field 1]-->
                        @if(\App\Models\ProductCustomField::where('items_custom_id', 1)->where('items_custom_field_status', 'enabled')->exists())
                        <th class="items_col_tableconfig_column_10 {{ config('table.tableconfig_column_10') }} tableconfig_column_10">
                            <a href="javascript:void(0)">{{ \App\Models\ProductCustomField::where('items_custom_id', 1)->first()->items_custom_field_name }}</a>
                        </th>
                        @endif

                        <!--tableconfig_column_11 [custom field 2]-->
                        @if(\App\Models\ProductCustomField::where('items_custom_id', 2)->where('items_custom_field_status', 'enabled')->exists())
                        <th class="items_col_tableconfig_column_11 {{ config('table.tableconfig_column_11') }} tableconfig_column_11">
                            <a href="javascript:void(0)">{{ \App\Models\ProductCustomField::where('items_custom_id', 2)->first()->items_custom_field_name }}</a>
                        </th>
                        @endif

                        <!--tableconfig_column_12 [custom field 3]-->
                        @if(\App\Models\ProductCustomField::where('items_custom_id', 3)->where('items_custom_field_status', 'enabled')->exists())
                        <th class="items_col_tableconfig_column_12 {{ config('table.tableconfig_column_12') }} tableconfig_column_12">
                            <a href="javascript:void(0)">{{ \App\Models\ProductCustomField::where('items_custom_id', 3)->first()->items_custom_field_name }}</a>
                        </th>
                        @endif

                        <!--tableconfig_column_13 [custom field 4]-->
                        @if(\App\Models\ProductCustomField::where('items_custom_id', 4)->where('items_custom_field_status', 'enabled')->exists())
                        <th class="items_col_tableconfig_column_13 {{ config('table.tableconfig_column_13') }} tableconfig_column_13">
                            <a href="javascript:void(0)">{{ \App\Models\ProductCustomField::where('items_custom_id', 4)->first()->items_custom_field_name }}</a>
                        </th>
                        @endif

                        <!--tableconfig_column_14 [custom field 5]-->
                        @if(\App\Models\ProductCustomField::where('items_custom_id', 5)->where('items_custom_field_status', 'enabled')->exists())
                        <th class="items_col_tableconfig_column_14 {{ config('table.tableconfig_column_14') }} tableconfig_column_14">
                            <a href="javascript:void(0)">{{ \App\Models\ProductCustomField::where('items_custom_id', 5)->first()->items_custom_field_name }}</a>
                        </th>
                        @endif

                        <!--tableconfig_column_15 [custom field 6]-->
                        @if(\App\Models\ProductCustomField::where('items_custom_id', 6)->where('items_custom_field_status', 'enabled')->exists())
                        <th class="items_col_tableconfig_column_15 {{ config('table.tableconfig_column_15') }} tableconfig_column_15">
                            <a href="javascript:void(0)">{{ \App\Models\ProductCustomField::where('items_custom_id', 6)->first()->items_custom_field_name }}</a>
                        </th>
                        @endif

                        <!--tableconfig_column_16 [custom field 7]-->
                        @if(\App\Models\ProductCustomField::where('items_custom_id', 7)->where('items_custom_field_status', 'enabled')->exists())
                        <th class="items_col_tableconfig_column_16 {{ config('table.tableconfig_column_16') }} tableconfig_column_16">
                            <a href="javascript:void(0)">{{ \App\Models\ProductCustomField::where('items_custom_id', 7)->first()->items_custom_field_name }}</a>
                        </th>
                        @endif

                        <!--tableconfig_column_17 [custom field 8]-->
                        @if(\App\Models\ProductCustomField::where('items_custom_id', 8)->where('items_custom_field_status', 'enabled')->exists())
                        <th class="items_col_tableconfig_column_17 {{ config('table.tableconfig_column_17') }} tableconfig_column_17">
                            <a href="javascript:void(0)">{{ \App\Models\ProductCustomField::where('items_custom_id', 8)->first()->items_custom_field_name }}</a>
                        </th>
                        @endif

                        <!--tableconfig_column_18 [custom field 9]-->
                        @if(\App\Models\ProductCustomField::where('items_custom_id', 9)->where('items_custom_field_status', 'enabled')->exists())
                        <th class="items_col_tableconfig_column_18 {{ config('table.tableconfig_column_18') }} tableconfig_column_18">
                            <a href="javascript:void(0)">{{ \App\Models\ProductCustomField::where('items_custom_id', 9)->first()->items_custom_field_name }}</a>
                        </th>
                        @endif

                        <!--tableconfig_column_19 [custom field 10]-->
                        @if(\App\Models\ProductCustomField::where('items_custom_id', 10)->where('items_custom_field_status', 'enabled')->exists())
                        <th class="items_col_tableconfig_column_19 {{ config('table.tableconfig_column_19') }} tableconfig_column_19">
                            <a href="javascript:void(0)">{{ \App\Models\ProductCustomField::where('items_custom_id', 10)->first()->items_custom_field_name }}</a>
                        </th>
                        @endif

                        @if(config('visibility.items_col_action'))
                        <th class="items_col_action with-table-config-icon actions_column"><a href="javascript:void(0)">{{ cleanLang(__('lang.action')) }}</a>

                            <!--[tableconfig]-->
                            <div class="table-config-icon">
                                <span class="text-default js-toggle-table-config-panel"
                                    data-target="table-config-items">
                                    <i class="sl-icon-settings">
                                    </i>
                                </span>
                            </div>
                            <!--[/tableconfig]-->

                        </th>
                        @endif
                    </tr>
                </thead>
                <tbody id="items-td-container">
                    <!--ajax content here-->
                    @include('pages.items.components.table.ajax')
                    <!--ajax content here-->

                    <!--bulk actions - change category-->
                    <input type="hidden" name="checkbox_actions_items_category" id="checkbox_actions_items_category">
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="20">
                            <!--load more button-->
                            @include('misc.load-more-button')
                            <!--load more button-->
                        </td>
                    </tr>
                </tfoot>
            </table>
            @endif @if (@count($items ?? []) == 0)
            <!--nothing found-->
            @include('notifications.no-results-found')
            <!--nothing found-->
            @endif
        </div>
    </div>
</div>