<div class="signup-form p-t-30" id="signup-form">

    <div class="x-heading">
        <h4>{{ $section->frontend_data_1 }}</h4>
    </div>
    <div class="x-sub-heading">
        {{ $section->frontend_data_2 }}
    </div>

    <form class="form-horizontal form-material x-form " id="loginForm" novalidate="novalidate" _lpchecked="1">
        <div class="form-group m-b-30">
            <div class="col-xs-12">
                <input class="form-control" type="text" name="full_name" id="full_name" placeholder="@lang('lang.name')"
                    autocomplete="off" style="cursor: auto;">
            </div>
        </div>
        <div class="form-group m-b-30">
            <div class="col-xs-12">
                <input class="form-control" type="text" name="email_address" id="email_address"
                    placeholder="@lang('lang.email')" autocomplete="off" style="cursor: auto;">
            </div>
        </div>
        <div class="form-group  m-b-30">
            <div class="col-xs-12">
                <input class="form-control" type="password" name="password" id="password"
                    placeholder="@lang('lang.password')" autocomplete="off" style="cursor: auto;">
            </div>
        </div>

        <!--country field (shown when enabled in signup form settings)-->
        @if(config('system.settings_signup_form_country') != 'not-included')
        <div class="form-group m-b-30 select-country">
            <div class="col-xs-12">
                <select class="select2-basic-with-search form-control form-control-sm" id="country" name="country">
                    <option></option>
                    @include('misc.country-list')
                </select>
            </div>
        </div>
        @endif

        <!--telephone field (shown when enabled in signup form settings)-->
        @if(config('system.settings_signup_form_telephone') != 'not-included')
        <div class="form-group m-b-30">
            <div class="col-xs-12">
                <input class="form-control" type="text" name="telephone" id="telephone"
                    placeholder="@lang('lang.telephone')" autocomplete="off">
            </div>
        </div>
        @endif

        <div class="input-group m-b-30">
            <input type="text" class="form-control" name="account_name" placeholder="{{ $section->frontend_data_4 }}"
                aria-describedby="basic-addon2">
            <span class="input-group-addon x-sub-domain"
                id="basic-addon2">.{{ config('system.settings_base_domain') }}</span>
        </div>

        <!--item-->
        <div class="form-group row m-b-30">
            <div class="col-sm-12">
                <select class="select2-basic form-control form-control-sm x-packages-list select2-preselected" id="plan"
                    name="plan" data-preselected="{{ request('ref') ?? ''}}">
                    @foreach($packages as $package)
                    @if($package->package_subscription_options == 'paid')
                    <option data-option="monthly" value="monthly_{{  $package->package_id }}">
                        {{  $package->package_name }}
                        ({{ runtimeMoneyFormat($package->package_amount_monthly) }} / @lang('lang.month'))
                    </option>
                    <option data-option="yearly" value="yearly_{{  $package->package_id }}">
                        {{  $package->package_name }}
                        ({{ runtimeMoneyFormat($package->package_amount_yearly) }} / @lang('lang.year'))
                    </option>
                    @else
                    <option data-option="free" value="free_{{  $package->package_id }}">{{  $package->package_name }}
                        (@lang('lang.free'))</option>
                    @endif
                    @endforeach
                </select>
                <input type="hidden" name="billing_cycle" id="billing_cycle" value="monthly">
            </div>
        </div>

        <!--(Google reCAPTCHA)-->
        @if(@config('system.settings_captcha_status') == 'enabled')
        <div class="m-b-20">
            {!! htmlFormSnippet([]) !!}
        </div>
        @endif

        <!--terms-->
        @if(config('system.settings_terms_of_service_status') == 'enabled')
        <div class="form-group form-group-checkbox row terms-of-service-link">
            <div class="col-12 p-t-5">
                <input type="checkbox" id="signup_agree_terms" name="signup_agree_terms"
                    class="filled-in chk-col-light-blue signup_agree_terms">
                <label class="p-l-10" for="signup_agree_terms">
                    <a href="#" data-toggle="modal" data-target="#termsModal">
                        {{ config('system.settings_terms_of_service_text') }}
                    </a>
                </label>
            </div>
        </div>
        @endif

        <div class="form-group text-center p-b-10">
            <div class="col-xs-12">
                <button class="btn btn-info btn-lg btn-block" id="accountSignupButton"
                    data-button-loading-annimation="yes" data-button-disable-on-click="yes"
                    data-url="{{ url('account/signup') }}" data-ajax-type="POST"
                    type="submit">{{ $section->frontend_data_3 }}</button>
            </div>
        </div>
    </form>

</div>