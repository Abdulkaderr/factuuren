@extends('landlord.settings.wrapper')
@section('settings_content')

<!--form-->
<div class="card">
    <div class="card-body" id="landlord-settings-form">

        <!--country field-->
        <div class="form-group row">
            <label class="col-12 col-form-label text-left">@lang('lang.country')</label>
            <div class="col-12">
                <select class="select2-basic form-control form-control-sm select2-preselected"
                    id="settings_signup_form_country"
                    name="settings_signup_form_country"
                    data-width="element"
                    data-preselected="{{ $settings->settings_signup_form_country ?? 'not-included' }}">
                    <option></option>
                    <option value="required">@lang('lang.required')</option>
                    <option value="optional">@lang('lang.optional')</option>
                    <option value="not-included">@lang('lang.not_included')</option>
                </select>
            </div>
        </div>

        <!--telephone field-->
        <div class="form-group row">
            <label class="col-12 col-form-label text-left">@lang('lang.telephone')</label>
            <div class="col-12">
                <select class="select2-basic form-control form-control-sm select2-preselected"
                    id="settings_signup_form_telephone"
                    name="settings_signup_form_telephone"
                    data-width="element"
                    data-preselected="{{ $settings->settings_signup_form_telephone ?? 'not-included' }}">
                    <option></option>
                    <option value="required">@lang('lang.required')</option>
                    <option value="optional">@lang('lang.optional')</option>
                    <option value="not-included">@lang('lang.not_included')</option>
                </select>
            </div>
        </div>

        <!--submit-->
        <div class="text-right m-t-30">
            <button type="submit" id="commonModalSubmitButton"
                class="btn btn-rounded-x btn-danger waves-effect text-left ajax-request"
                data-url="{{ url('app-admin/settings/signup-form') }}" data-form-id="landlord-settings-form"
                data-loading-target="" data-ajax-type="post" data-type="form"
                data-on-start-submit-button="disable">@lang('lang.save_changes')</button>
        </div>

    </div>
</div>

@endsection
