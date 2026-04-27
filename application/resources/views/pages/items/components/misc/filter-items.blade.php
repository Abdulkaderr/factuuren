<!-- right-sidebar -->
<div class="right-sidebar" id="sidepanel-filter-items">
    <form>
        <div class="slimscrollright">
            <!--title-->
            <div class="rpanel-title">
                <i class="icon-Filter-2"></i>{{ cleanLang(__('lang.filter_products')) }}
                <span>
                    <i class="ti-close js-close-side-panels" data-target="sidepanel-filter-items"></i>
                </span>
            </div>

            <!--body-->
            <div class="r-panel-body">

                <!--rate-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.rate')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-6 input-group input-group-sm">
                                <span class="input-group-addon">{{ config('system.settings_system_currency_symbol') }}</span>
                                <input type="number" name="filter_item_rate_min" id="filter_item_rate_min"
                                    class="form-control form-control-sm" placeholder="{{ cleanLang(__('lang.minimum')) }}"
                                    value="{{ config('filter.saved_data.filter_item_rate_min') ?? '' }}">
                            </div>
                            <div class="col-md-6 input-group input-group-sm">
                                <span class="input-group-addon">{{ config('system.settings_system_currency_symbol') }}</span>
                                <input type="number" name="filter_item_rate_max" id="filter_item_rate_max"
                                    class="form-control form-control-sm" placeholder="{{ cleanLang(__('lang.maximum')) }}"
                                    value="{{ config('filter.saved_data.filter_item_rate_max') ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!--categorgies-->
                @php
                $saved_categories = config('filter.saved_data.filter_item_categoryid') ?? [];
                if (!is_array($saved_categories)) {
                    $saved_categories = [];
                }
                @endphp
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.category')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <select name="filter_item_categoryid" id="filter_item_categoryid"
                                    class="form-control form-control-sm select2-basic select2-multiple select2-hidden-accessible"
                                    multiple="multiple" tabindex="-1" aria-hidden="true">
                                    @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}" {{ in_array($category->category_id, $saved_categories) ? 'selected' : '' }}>
                                        {{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!--description-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.description')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" name="filter_item_notes" id="filter_item_notes"
                                    class="form-control form-control-sm"
                                    value="{{ config('filter.saved_data.filter_item_notes') ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!--tax status-->
                @php
                $saved_tax_status = config('filter.saved_data.filter_item_tax_status') ?? [];
                if (!is_array($saved_tax_status)) {
                    $saved_tax_status = [];
                }
                @endphp
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.tax_status')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <select name="filter_item_tax_status" id="filter_item_tax_status"
                                    class="form-control form-control-sm select2-basic select2-multiple select2-hidden-accessible"
                                    multiple="multiple" tabindex="-1" aria-hidden="true">
                                    <option value="taxable" {{ in_array('taxable', $saved_tax_status) ? 'selected' : '' }}>{{ cleanLang(__('lang.taxable')) }}</option>
                                    <option value="exempt" {{ in_array('exempt', $saved_tax_status) ? 'selected' : '' }}>{{ cleanLang(__('lang.exempt')) }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!--default tax-->
                @php
                $saved_default_tax = config('filter.saved_data.filter_item_default_tax') ?? [];
                if (!is_array($saved_default_tax)) {
                    $saved_default_tax = [];
                }
                @endphp
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.default_tax')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <select name="filter_item_default_tax" id="filter_item_default_tax"
                                    class="form-control form-control-sm select2-basic select2-multiple select2-hidden-accessible"
                                    multiple="multiple" tabindex="-1" aria-hidden="true">
                                    @foreach(\App\Models\TaxRate::orderBy('taxrate_name', 'asc')->get() as $taxRate)
                                    <option value="{{ $taxRate->taxrate_id }}" {{ in_array($taxRate->taxrate_id, $saved_default_tax) ? 'selected' : '' }}>
                                        {{ $taxRate->taxrate_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!--custom fields-->
                @if(\App\Models\ProductCustomField::where('items_custom_field_status', 'enabled')->exists())
                @foreach(\App\Models\ProductCustomField::where('items_custom_field_status', 'enabled')->get() as $customField)
                <div class="filter-block">
                    <div class="title">
                        {{ $customField->items_custom_field_name }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" name="filter_item_custom_field_{{ $customField->items_custom_id }}"
                                    id="filter_item_custom_field_{{ $customField->items_custom_id }}"
                                    class="form-control form-control-sm"
                                    value="{{ config('filter.saved_data.filter_item_custom_field_' . $customField->items_custom_id) ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif

                <!--remember filters-->
                <div class="modal-selector m-t-20 p-b-0 p-l-35 p-t-20">
                    <div class="filter-block">
                        <div class="fields">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group form-group-checkbox m-b-0">
                                        <input type="checkbox" id="filter_remember" name="filter_remember"
                                            class="filled-in chk-col-light-blue"
                                            {{ config('filter.status') == 'active' ? 'checked' : '' }}>
                                        <label class="p-l-30"
                                            for="filter_remember">@lang('lang.remember_filters')</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--buttons-->
                <div class="buttons-block">
                    <a href="{{ url('/items?clear-filter=yes') }}"
                        class="btn btn-rounded-x btn-secondary">@lang('lang.forget_filters')</a>
                    <input type="hidden" name="action" value="search">
                    <input type="hidden" name="source" value="{{ $page['source_for_filter_panels'] ?? '' }}">
                    <input type="hidden" name="query-type" value="filter">
                    <button type="button" class="btn btn-rounded-x btn-danger js-ajax-ux-request apply-filter-button"
                        data-url="{{ urlResource('/items/search') }}"
                        data-type="form" data-ajax-type="GET">{{ cleanLang(__('lang.apply_filter')) }}</button>
                </div>
            </div>
            <!--body-->
        </div>
    </form>
</div>
<!--sidebar-->