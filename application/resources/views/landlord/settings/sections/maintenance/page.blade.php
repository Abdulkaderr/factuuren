@extends('landlord.settings.wrapper')
@section('settings_content')

<!--form-->
<div class="card">
    <div class="card-body" id="landlord-settings-maintenance-form">

        <!--maintenance mode status-->
        <div class="form-group row">
            <label class="col-12 col-form-label text-left">@lang('lang.maintenance_mode_status')</label>
            <div class="col-12">
                <select class="select2-basic form-control form-control-sm select2-preselected"
                    id="settings_maintenace_mode_status" name="settings_maintenace_mode_status" data-width="element"
                    data-preselected="{{ $settings->settings_maintenace_mode_status ?? 'disabled' }}">
                    <option value="enabled">@lang('lang.enabled')</option>
                    <option value="disabled">@lang('lang.disabled')</option>
                </select>
            </div>
        </div>

        <!--maintenance mode message-->
        <div class="form-group row">
            <label class="col-12 col-form-label text-left">@lang('lang.maintenance_mode_message')</label>
            <div class="col-12 p-r-4">
                <textarea class="form-control form-control-sm tinymce-textarea" rows="5"
                    name="html_settings_maintenace_mode_message"
                    id="html_settings_maintenace_mode_message">{{ $settings->settings_maintenace_mode_message ?? '' }}</textarea>
            </div>
        </div>

        <!--submit-->
        <div class="text-right p-t-30">
            <button type="button"
                class="btn btn-danger waves-effect text-left ajax-request"
                data-url="{{ url('/app-admin/settings/maintenance') }}"
                data-type="form"
                data-form-id="landlord-settings-maintenance-form"
                data-ajax-type="post"
                data-loading-target="body">
                @lang('lang.save_changes')
            </button>
        </div>

    </div>
</div>

@endsection
