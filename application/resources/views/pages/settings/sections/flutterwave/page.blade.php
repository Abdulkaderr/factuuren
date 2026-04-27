@extends('pages.settings.ajaxwrapper')
@section('settings-page')
<!--settings-->
<form class="form" id="settingsFormFlutterwave">


    <!--public key-->
    <div class="form-group row">
        <label class="col-12 control-label col-form-label required">{{ cleanLang(__('lang.public_key')) }}*
            <span class="align-middle text-themecontrast font-16" data-toggle="tooltip"
                title="{{ cleanLang(__('lang.flutterwave_general_info')) }}" data-placement="top"><i
                    class="ti-info-alt"></i></span>
        </label>
        <div class="col-12">
            <input type="text" class="form-control form-control-sm" id="settings2_flutterwave_public_key"
                name="settings2_flutterwave_public_key" value="{{ $settings->settings2_flutterwave_public_key ?? '' }}">
        </div>
    </div>

    <!--secret key-->
    <div class="form-group row">
        <label class="col-12 control-label col-form-label required">{{ cleanLang(__('lang.secret_key')) }}*
            <span class="align-middle text-themecontrast font-16" data-toggle="tooltip"
                title="{{ cleanLang(__('lang.flutterwave_general_info')) }}" data-placement="top"><i
                    class="ti-info-alt"></i></span>
        </label>
        <div class="col-12">
            <input type="text" class="form-control form-control-sm" id="settings2_flutterwave_secret_key"
                name="settings2_flutterwave_secret_key" value="{{ $settings->settings2_flutterwave_secret_key ?? '' }}">
        </div>
    </div>

    <!--webhook secret hash-->
    <div class="form-group row">
        <label class="col-12 control-label col-form-label required">{{ cleanLang(__('lang.webhook_secret_hash')) }}*
            <span class="align-middle text-themecontrast font-16" data-toggle="tooltip"
                title="{{ cleanLang(__('lang.flutterwave_webhook_hash_info')) }}" data-placement="top"><i
                    class="ti-info-alt"></i></span>
        </label>
        <div class="col-12">
            <input type="text" class="form-control form-control-sm" id="settings2_flutterwave_webhook_hash"
                name="settings2_flutterwave_webhook_hash" value="{{ $settings->settings2_flutterwave_webhook_hash ?? '' }}">
        </div>
    </div>


    <!--currency code-->
    <div class="form-group row">
        <label class="col-12 control-label col-form-label required">{{ cleanLang(__('lang.currency_code')) }}*
            <span class="align-middle text-themecontrast font-16" data-toggle="tooltip"
                title="{{ cleanLang(__('lang.payment_gateway_currency_code_example')) }}" data-placement="top"><i
                    class="ti-info-alt"></i></span>
        </label>
        <div class="col-12">
            <input type="text" class="form-control form-control-sm" id="settings2_flutterwave_currency_code"
                name="settings2_flutterwave_currency_code" value="{{ $settings->settings2_flutterwave_currency_code ?? '' }}">
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
            <input type="text" class="form-control form-control-sm" id="settings2_flutterwave_display_name"
                name="settings2_flutterwave_display_name" value="{{ $settings->settings2_flutterwave_display_name ?? '' }}">
        </div>
    </div>

        <!--webhooks url-->
    <div class="form-group row">
        <label class="col-12 control-label col-form-label required">{{ cleanLang(__('lang.webhooks_url')) }}*
            <span class="align-middle text-themecontrast font-16" data-toggle="tooltip"
                title="{{ cleanLang(__('lang.add_this_inside_your_dashboard')) }} (Paystack)" data-placement="top"><i
                    class="ti-info-alt"></i></span>
        </label>
        <div class="col-12">
            <input type="text" class="form-control form-control-sm" id="settings_stripe_ipn_url"
                name="settings2_paystack_ipn_url" value="{{ url('/api/flutterwave/webhooks') }}" disabled>
        </div>
    </div>

    <div class="line"></div>

    <!--Enabled-->
    <div class="form-group form-group-checkbox row">
        <label class="col-3 col-form-label" title="Foo">{{ cleanLang(__('lang.enable_payment_method')) }}</label>
        <div class="col-9 p-t-5">
            <input type="checkbox" id="settings2_flutterwave_status" name="settings2_flutterwave_status"
                class="filled-in chk-col-light-blue" {{ runtimePrechecked($settings->settings2_flutterwave_status) }}>
            <label for="settings2_flutterwave_status"></label>
        </div>
    </div>

    <!--buttons-->
    <div class="text-right">
        <button type="submit" id="commonModalSubmitButton" class="btn btn-rounded-x btn-danger waves-effect text-left ajax-request"
            data-url="/settings/flutterwave" data-loading-target="" data-ajax-type="PUT" data-type="form"
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
