@foreach($items as $item)
<!--each row-->
<tr id="item_{{ $item->item_id }}" class="{{ $item->pinned_status ?? '' }}">
    @if(config('visibility.items_col_checkboxes'))
    <td class="items_col_checkbox checkitem" id="items_col_checkbox_{{ $item->item_id }}">
        <!--list checkbox-->
        <span class="list-checkboxes display-inline-block w-px-20">
            <input type="checkbox" id="listcheckbox-items-{{ $item->item_id }}" name="ids[{{ $item->item_id }}]"
                class="listcheckbox listcheckbox-items filled-in chk-col-light-blue items-checkbox"
                data-actions-container-class="items-checkbox-actions-container" data-item-id="{{ $item->item_id }}"
                data-unit="{{ $item->unit->unit_name }}" data-quantity="1"
                data-description="{{ $item->item_description }}" data-type="{{ $item->item_type }}"
                data-length="{{ $item->item_dimensions_length }}" data-width="{{ $item->item_dimensions_width }}"
                data-tax-status="{{ $item->item_tax_status }}"
                data-has-estimation-notes="{{ $item->has_estimation_notes }}"
                data-estimation-notes="{{ $item->estimation_notes_encoded }}" data-rate="{{ $item->item_rate }}"
                data-default-tax="{{ $item->item_default_tax }}" data-item-notes="{{ $item->item_notes }}">
            <label for="listcheckbox-items-{{ $item->item_id }}"></label>
        </span>
    </td>
    @endif

    <!--tableconfig_column_1 [title]-->
    <td class="items_col_tableconfig_column_1 {{ config('table.tableconfig_column_1') }} tableconfig_column_1"
        id="items_col_description_{{ $item->item_id }}">
        <a href="javascript:void(0);"
            class="edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
            data-toggle="modal" data-target="#commonModal"
            data-url="{{ urlResource('/items/'.$item->item_id.'/edit') }}" data-loading-target="commonModalBody"
            data-modal-title="{{ cleanLang(__('lang.edit_product')) }}"
            data-action-url="{{ urlResource('/items/'.$item->item_id.'?ref=list') }}" data-action-method="PUT"
            data-action-ajax-class="" data-action-ajax-loading-target="items-td-container">
            @if(config('settings.trimmed_title'))
            {{ runtimeProductStripTags(str_limit($item->item_description ?? '---', 45)) }}
            @else
            {{ runtimeProductStripTags($item->item_description) }}
            @endif
        </a>
    </td>

    <!--tableconfig_column_2 [rate]-->
    <td class="items_col_tableconfig_column_2 {{ config('table.tableconfig_column_2') }} tableconfig_column_2"
        id="items_col_rate_{{ $item->item_id }}">
        {{ runtimeMoneyFormat($item->item_rate) }}
    </td>

    <!--tableconfig_column_3 [unit]-->
    <td class="items_col_tableconfig_column_3 {{ config('table.tableconfig_column_3') }} tableconfig_column_3"
        id="items_col_unit_{{ $item->item_id }}">
        {{ $item->unit->unit_name ?? '---' }}
    </td>

    <!--tableconfig_column_4 [category]-->
    <td class="items_col_tableconfig_column_4 {{ config('table.tableconfig_column_4') }} tableconfig_column_4 ucwords"
        id="items_col_category_{{ $item->item_id }}">
        {{ str_limit($item->category_name ?? '---', 30) }}
    </td>

    <!--tableconfig_column_5 [number sold]-->
    <td class="items_col_tableconfig_column_5 {{ config('table.tableconfig_column_5') }} tableconfig_column_5">
        {{ $item->count_sold }}
    </td>

    <!--tableconfig_column_6 [amount sold]-->
    <td class="items_col_tableconfig_column_6 {{ config('table.tableconfig_column_6') }} tableconfig_column_6">
        {{ runtimeMoneyFormat($item->sum_sold) }}
    </td>

    <!--tableconfig_column_7 [description]-->
    <td class="items_col_tableconfig_column_7 {{ config('table.tableconfig_column_7') }} tableconfig_column_7">
        {{ str_limit($item->item_notes ?? '---', 50) }}
    </td>

    <!--tableconfig_column_8 [tax status]-->
    <td class="items_col_tableconfig_column_8 {{ config('table.tableconfig_column_8') }} tableconfig_column_8">
        {{ ucfirst($item->item_tax_status ?? '---') }}
    </td>

    <!--tableconfig_column_9 [default tax]-->
    <td class="items_col_tableconfig_column_9 {{ config('table.tableconfig_column_9') }} tableconfig_column_9">
        {{ $item->defaultTaxRate->taxrate_name ?? '---' }}
    </td>

    <!--tableconfig_column_10 [custom field 1]-->
    @if(\App\Models\ProductCustomField::where('items_custom_id', 1)->where('items_custom_field_status', 'enabled')->exists())
    <td class="items_col_tableconfig_column_10 {{ config('table.tableconfig_column_10') }} tableconfig_column_10">
        {{ $item->item_custom_field_1 ?? '---' }}
    </td>
    @endif

    <!--tableconfig_column_11 [custom field 2]-->
    @if(\App\Models\ProductCustomField::where('items_custom_id', 2)->where('items_custom_field_status', 'enabled')->exists())
    <td class="items_col_tableconfig_column_11 {{ config('table.tableconfig_column_11') }} tableconfig_column_11">
        {{ $item->item_custom_field_2 ?? '---' }}
    </td>
    @endif

    <!--tableconfig_column_12 [custom field 3]-->
    @if(\App\Models\ProductCustomField::where('items_custom_id', 3)->where('items_custom_field_status', 'enabled')->exists())
    <td class="items_col_tableconfig_column_12 {{ config('table.tableconfig_column_12') }} tableconfig_column_12">
        {{ $item->item_custom_field_3 ?? '---' }}
    </td>
    @endif

    <!--tableconfig_column_13 [custom field 4]-->
    @if(\App\Models\ProductCustomField::where('items_custom_id', 4)->where('items_custom_field_status', 'enabled')->exists())
    <td class="items_col_tableconfig_column_13 {{ config('table.tableconfig_column_13') }} tableconfig_column_13">
        {{ $item->item_custom_field_4 ?? '---' }}
    </td>
    @endif

    <!--tableconfig_column_14 [custom field 5]-->
    @if(\App\Models\ProductCustomField::where('items_custom_id', 5)->where('items_custom_field_status', 'enabled')->exists())
    <td class="items_col_tableconfig_column_14 {{ config('table.tableconfig_column_14') }} tableconfig_column_14">
        {{ $item->item_custom_field_5 ?? '---' }}
    </td>
    @endif

    <!--tableconfig_column_15 [custom field 6]-->
    @if(\App\Models\ProductCustomField::where('items_custom_id', 6)->where('items_custom_field_status', 'enabled')->exists())
    <td class="items_col_tableconfig_column_15 {{ config('table.tableconfig_column_15') }} tableconfig_column_15">
        {{ $item->item_custom_field_6 ?? '---' }}
    </td>
    @endif

    <!--tableconfig_column_16 [custom field 7]-->
    @if(\App\Models\ProductCustomField::where('items_custom_id', 7)->where('items_custom_field_status', 'enabled')->exists())
    <td class="items_col_tableconfig_column_16 {{ config('table.tableconfig_column_16') }} tableconfig_column_16">
        {{ $item->item_custom_field_7 ?? '---' }}
    </td>
    @endif

    <!--tableconfig_column_17 [custom field 8]-->
    @if(\App\Models\ProductCustomField::where('items_custom_id', 8)->where('items_custom_field_status', 'enabled')->exists())
    <td class="items_col_tableconfig_column_17 {{ config('table.tableconfig_column_17') }} tableconfig_column_17">
        {{ $item->item_custom_field_8 ?? '---' }}
    </td>
    @endif

    <!--tableconfig_column_18 [custom field 9]-->
    @if(\App\Models\ProductCustomField::where('items_custom_id', 9)->where('items_custom_field_status', 'enabled')->exists())
    <td class="items_col_tableconfig_column_18 {{ config('table.tableconfig_column_18') }} tableconfig_column_18">
        {{ $item->item_custom_field_9 ?? '---' }}
    </td>
    @endif

    <!--tableconfig_column_19 [custom field 10]-->
    @if(\App\Models\ProductCustomField::where('items_custom_id', 10)->where('items_custom_field_status', 'enabled')->exists())
    <td class="items_col_tableconfig_column_19 {{ config('table.tableconfig_column_19') }} tableconfig_column_19">
        {{ $item->item_custom_field_10 ?? '---' }}
    </td>
    @endif

    @if(config('visibility.items_col_action'))
    <td class="items_col_action actions_column" id="items_col_action_{{ $item->item_id }}">
        <!--action button-->
        <span class="list-table-action font-size-inherit">
            <!--delete-->
            @if(config('visibility.action_buttons_delete'))
            <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="{{ cleanLang(__('lang.delete_product')) }}"
                data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="DELETE"
                data-url="{{ url('/') }}/items/{{ $item->item_id }}">
                <i class="sl-icon-trash"></i>
            </button>
            @endif
            @if(config('visibility.action_buttons_edit'))
            <!--edit-->
            <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ urlResource('/items/'.$item->item_id.'/edit') }}" data-loading-target="commonModalBody"
                data-modal-title="{{ cleanLang(__('lang.edit_product')) }}"
                data-action-url="{{ urlResource('/items/'.$item->item_id.'?ref=list') }}" data-action-method="PUT"
                data-action-ajax-class="" data-action-ajax-loading-target="items-td-container">
                <i class="sl-icon-note"></i>
            </button>
            <!--tasks-->
            <button type="button" title="@lang('lang.product_tasks')"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm js-toggle-side-panel"
                data-create-task-action-url="{{ url('items/tasks?item_id='.$item->item_id) }}"
                data-create-task-url="{{ url('items/tasks/create?item_id='.$item->item_id) }}"
                id="js-products-automation-tasks" data-url="{{ url('items/'.$item->item_id.'/tasks') }}"
                data-progress-bar="hidden" data-loading-target="products-tasks-side-panel-content"
                data-target="products-tasks-side-panel">
                <i class="ti-menu-alt"></i>
            </button>

            @endif
            <!--more button (team)-->
            @if(config('visibility.action_buttons_edit') == 'show')
            <span class="list-table-action dropdown font-size-inherit">
                <button type="button" id="listTableAction" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false" title="{{ cleanLang(__('lang.more')) }}"
                    class="data-toggle-action-tooltip btn btn-outline-default-light btn-circle btn-sm">
                    <i class="ti-more"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="listTableAction">
                    <!--actions button - change category-->
                    <a class="dropdown-item actions-modal-button js-ajax-ux-request reset-target-modal-form"
                        href="javascript:void(0)" data-toggle="modal" data-target="#actionsModal"
                        data-modal-title="{{ cleanLang(__('lang.change_category')) }}"
                        data-url="{{ url('/items/change-category') }}"
                        data-action-url="{{ urlResource('/items/change-category?id='.$item->item_id) }}"
                        data-loading-target="actionsModalBody" data-action-method="POST">
                        {{ cleanLang(__('lang.change_category')) }}</a>
                    <!--actions button - attach project -->
                </div>
            </span>
            @endif

            <!--pin-->
            <span class="list-table-action">
                <a href="javascript:void(0);" title="{{ cleanLang(__('lang.pinning')) }}"
                    data-parent="item_{{ $item->item_id }}" data-url="{{ url('/items/'.$item->item_id.'/pinning') }}"
                    class="data-toggle-action-tooltip btn btn-outline-default-light btn-circle btn-sm opacity-4 js-toggle-pinning">
                    <i class="ti-pin2"></i>
                </a>
            </span>

        </span>
        <!--action button-->
    </td>
    @endif
</tr>
@endforeach
<!--each row-->