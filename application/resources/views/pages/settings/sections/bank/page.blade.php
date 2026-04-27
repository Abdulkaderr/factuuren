@extends('pages.settings.ajaxwrapper')
@section('settings-page')
<!--settings-->
<form class="form" id="settingsFormBank">


    <!--bank details-->
    <div class="form-group row">
        <label class="col-12 control-label col-form-label required">{{ cleanLang(__('lang.banking_details')) }}*</label>
        <div class="col-12">
            <textarea class="form-control form-control-sm tinymce-textarea" rows="5" name="settings_bank_details"
                id="settings_bank_details">
                {{ $settings->settings_bank_details }}
            </textarea>
        </div>
    </div>

    <!--show on invoices [UPCOMING]-->
    <div class="form-group form-group-checkbox row hidden">
        <label class="col-3 col-form-label">{{ cleanLang(__('lang.show_on_invoices')) }}</label>
        <div class="col-9 p-t-5">
            <input type="checkbox" id="settings_stripe_display_name" name="settings_bank_display_name"
                class="filled-in chk-col-light-blue"
                {{ runtimePrechecked($settings->settings_bank_display_name ?? '') }}>
            <label for="settings_bank_display_name"></label>
        </div>
    </div>

    <!--display name-->
    <div class="form-group row">
        <label class="col-12 control-label col-form-label required">{{ cleanLang(__('lang.display_name')) }}*
            <span class="align-middle text-themecontrast font-16" data-toggle="tooltip"
                title="{{ cleanLang(__('lang.display_name_info')) }}" data-placement="top"><i
                    class="ti-info-alt"></i></span>
        </label>
        <div class="col-12">
            <input type="text" class="form-control form-control-sm" id="settings_bank_display_name"
                name="settings_bank_display_name" value="{{ $settings->settings_bank_display_name ?? '' }}">
        </div>
    </div>


    <!--Enabled-->
    <div class="form-group form-group-checkbox row">
        <label class="col-3 col-form-label">{{ cleanLang(__('lang.enable_payment_method')) }}</label>
        <div class="col-9 p-t-5">
            <input type="checkbox" id="settings_bank_status" name="settings_bank_status"
                class="filled-in chk-col-light-blue" {{ runtimePrechecked($settings->settings_bank_status) }}>
            <label for="settings_bank_status"></label>
        </div>
    </div>

    <!--variables you can use in the bank details-->
    <div class="bg-contrast p-20 m-b-30">
        <h5>@lang('lang.variables') <span class="align-middle text-info font-16" data-toggle="tooltip"
                title="@lang('lang.variables_instruction')" data-placement="top"><i class="ti-info-alt"></i></span></h5>

        <div class="line"></div>

        <span class="display-inline-block m-r-15">
            {invoice_id}
        </span>

        <span class="display-inline-block m-r-15">
            {invoice_id_formatted}
        </span>

        <span class="display-inline-block m-r-15">
            {invoice_total}
        </span>

        <span class="display-inline-block m-r-15">
            {balance_due}
        </span>

        <span class="display-inline-block m-r-15">
            {client_company_name}
        </span>

        <span class="display-inline-block m-r-15">
            {client_id}
        </span>

        <span class="display-inline-block m-r-15">
            {due_date}
        </span>

        <span class="display-inline-block m-r-15">
            {project_title}
        </span>

        <span class="display-inline-block m-r-15">
            {company_name}
        </span>

        <span class="display-inline-block m-r-15">
            {invoice_created_by}
        </span>

    </div>



    <!--buttons-->
    <div class="text-right">
        <button type="submit" id="settings-submit-button" class="btn btn-rounded-x btn-danger waves-effect text-left"
            data-url="/settings/bank" data-loading-target="" data-ajax-type="PUT" data-type="form"
            data-on-start-submit-button="disable">{{ cleanLang(__('lang.save_changes')) }}</button>
    </div>
</form>


@if(config('system.settings_type') == 'standalone')
<!--[standalone] - settings documentation help-->
<a href="https://growcrm.io/documentation" target="_blank" class="btn btn-sm btn-info help-documentation"><i
        class="ti-info-alt"></i>
    {{ cleanLang(__('lang.help_documentation')) }}
</a>
@endif

@endsection