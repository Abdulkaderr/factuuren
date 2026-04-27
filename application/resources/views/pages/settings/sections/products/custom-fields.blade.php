@extends('pages.settings.ajaxwrapper')
@section('settings-page')

<!--settings-->
<form class="form" id="settingsFormProductCustomFields">

    <!-- Custom CSS for this page -->
    <style>

    </style>

    <!-- Custom Fields Table -->
    <table class="custom-fields-table">
        <thead>
            <tr>
                <th>@lang('lang.field_name')</th>
                <th class="text-center">@lang('lang.show_on_invoice') <span class="align-middle text-info font-16"
                        data-toggle="tooltip" title="@lang('lang.products_custom_fields_info')" data-placement="top"><i
                            class="ti-info-alt"></i></span></th>
                <th class="text-center">@lang('lang.status')</th>
            </tr>
        </thead>

        <!-- First 5 rows (always visible) -->
        <tbody>
            @foreach($fields->take(5) as $field)
            <tr>
                <!-- Field Name Input -->
                <td>
                    <input type="text" class="form-control form-control-sm field-name-input"
                        name="items_custom_field_name[{{ $field->items_custom_id }}]"
                        value="{{ $field->items_custom_field_name ?? '' }}">
                </td>

                <!-- Show On Invoice Toggle -->
                <td class="toggle-wrapper">
                    <div class="switch">
                        <label>
                            <input type="checkbox"
                                name="items_custom_field_show_on_invoice[{{ $field->items_custom_id }}]"
                                {{ runtimePrechecked($field->items_custom_field_show_on_invoice ?? 'no') }}>
                            <span class="lever switch-col-light-blue"></span>
                        </label>
                    </div>
                </td>

                <!-- Status Toggle -->
                <td class="toggle-wrapper">
                    <div class="switch">
                        <label>
                            <input type="checkbox" name="items_custom_field_status[{{ $field->items_custom_id }}]"
                                {{ runtimePrechecked($field->items_custom_field_status ?? 'disabled') }}>
                            <span class="lever switch-col-light-blue"></span>
                        </label>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>

        <!-- Rows 6-10 (initially hidden) -->
        <tbody id="custom-fields-hidden-rows" class="hidden">
            @foreach($fields->slice(5) as $field)
            <tr>
                <!-- Field Name Input -->
                <td>
                    <input type="text" class="form-control form-control-sm field-name-input"
                        name="items_custom_field_name[{{ $field->items_custom_id }}]"
                        value="{{ $field->items_custom_field_name ?? '' }}">
                </td>

                <!-- Show On Invoice Toggle -->
                <td class="toggle-wrapper">
                    <div class="switch">
                        <label>
                            <input type="checkbox"
                                name="items_custom_field_show_on_invoice[{{ $field->items_custom_id }}]"
                                {{ runtimePrechecked($field->items_custom_field_show_on_invoice ?? 'no') }}>
                            <span class="lever switch-col-light-blue"></span>
                        </label>
                    </div>
                </td>

                <!-- Status Toggle -->
                <td class="toggle-wrapper">
                    <div class="switch">
                        <label>
                            <input type="checkbox" name="items_custom_field_status[{{ $field->items_custom_id }}]"
                                {{ runtimePrechecked($field->items_custom_field_status ?? 'disabled') }}>
                            <span class="lever switch-col-light-blue"></span>
                        </label>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Show More Button -->
    <div class="show-more-button">
        <button type="button" id="show-more-custom-fields" class="btn btn-sm btn-light">
            @lang('lang.show_more')
        </button>
    </div>


    <!-- Option 1: Alert Box (Recommended) -->
    <div class="alert alert-danger m-b-40" role="alert">
        <i class="sl-icon-info"></i>
        <strong>@lang('lang.warning'):</strong> @lang('lang.item_custom_fields_warning')
    </div>

    <!-- Action Buttons -->
    <div class="form-group row">
        <div class="col-6 text-left">
            <a href="{{ config('system.help_docs_url') }}" target="_blank" class="btn btn-info btn-sm">
                <i class="ti-help"></i> @lang('lang.help_documentation')
            </a>
        </div>
        <div class="col-6 text-right">
            <button type="button" id="product-custom-fields-button"
                class="btn btn-rounded-x btn-danger waves-effect text-left ajax-request"
                data-url="/settings/products/custom-fields" data-ajax-type="PUT"
                data-form-id="settingsFormProductCustomFields" data-type="form" data-on-start-submit-button="disable">
                @lang('lang.save_changes')
            </button>
        </div>
    </div>

</form>
@endsection