<ul class="inner-menu p-b-70">

    <!--module extension point - allows modules to inject content-->
    @stack('landlord_settings_menu_1')

    <!--general settings-->
    <li>
        <a class="inner-menu-item {{ $page['inner_menu_general'] ?? '' }}"
            href="{{ url('app-admin/settings/general') }}">@lang('lang.general_settings')</a>
    </li>

    <!--module extension point - allows modules to inject content-->
    @stack('landlord_settings_menu_2')

    <!--domain settings-->
    <li>
        <a class="inner-menu-item {{ $page['inner_menu_domain'] ?? '' }}"
            href="{{ url('app-admin/settings/domain') }}">@lang('lang.domain_settings')</a>
    </li>

    <!--module extension point - allows modules to inject content-->
    @stack('landlord_settings_menu_3')

    <!--account_settings-->
    <li>
        <a class="inner-menu-item {{ $page['inner_menu_defaults'] ?? '' }}"
            href="{{ url('app-admin/settings/defaults') }}">@lang('lang.account_settings')</a>
    </li>

    <!--signup form settings-->
    <li>
        <a class="inner-menu-item {{ $page['inner_menu_signup_form'] ?? '' }}"
            href="{{ url('app-admin/settings/signup-form') }}">@lang('lang.signup_form_settings')</a>
    </li>

    <!--module extension point - allows modules to inject content-->
    @stack('landlord_settings_menu_4')

    <!--company details-->
    <li>
        <a class="inner-menu-item {{ $page['inner_menu_company'] ?? '' }}"
            href="{{ url('app-admin/settings/company') }}">@lang('lang.company_details')</a>
    </li>

    <!--module extension point - allows modules to inject content-->
    @stack('landlord_settings_menu_5')

    <!--email-->
    <li class="group-menu-wrapper {{ $page['inner_group_menu_email'] ?? '' }}">
        <a class="inner-menu-item {{ $page['inner_group_menu_email'] ?? '' }}" href="javascript:void(0);"
            aria-expanded="false">@lang('lang.email')</a>
        <ul aria-expanded="false" class="hidden">
            <!--email_templates-->
            <li>
                <a class="{{ $page['inner_menu_emailtemplates'] ?? '' }}"
                    href="{{ url('app-admin/settings/emailtemplates') }}">@lang('lang.email_templates')</a>
            </li>

            <!--email_settings-->
            <li>
                <a class="{{ $page['inner_menu_email'] ?? '' }}"
                    href="{{ url('app-admin/settings/email') }}">@lang('lang.email_settings')</a>
            </li>


            <!--email_log-->
            <li>
                <a class="{{ $page['inner_menu_email_log'] ?? '' }}"
                    href="{{ url('app-admin/settings/emaillog') }}">@lang('lang.email_log')</a>
            </li>

            <!--smtp settings-->
            <li>
                <a class="{{ $page['inner_menu_smtp'] ?? '' }}"
                    href="{{ url('app-admin/settings/smtp') }}">@lang('lang.smtp_settings')</a>
            </li>
        </ul>
    </li>

    <!--module extension point - allows modules to inject content-->
    @stack('landlord_settings_menu_6')

    <!--currency settings-->
    <li>
        <a class="inner-menu-item {{ $page['inner_menu_currency'] ?? '' }}"
            href="{{ url('app-admin/settings/currency') }}">@lang('lang.currency')</a>
    </li>

    <!--module extension point - allows modules to inject content-->
    @stack('landlord_settings_menu_7')

    <!--logo settings-->
    <li>
        <a class="inner-menu-item {{ $page['inner_menu_logo'] ?? '' }}"
            href="{{ url('app-admin/settings/logo') }}">@lang('lang.logo')</a>
    </li>

    <!--module extension point - allows modules to inject content-->
    @stack('landlord_settings_menu_8')

    <!--cronjob-->
    <li>
        <a class="inner-menu-item {{ $page['inner_menu_cronjob'] ?? '' }}"
            href="{{ url('app-admin/settings/cronjob') }}">@lang('lang.cronjob')</a>
    </li>

    <!--module extension point - allows modules to inject content-->
    @stack('landlord_settings_menu_9')

    <!--free trial-->
    <li>
        <a class="inner-menu-item {{ $page['inner_menu_free_trial'] ?? '' }}"
            href="{{ url('app-admin/settings/freetrial') }}">@lang('lang.free_trial')</a>
    </li>


    <!--module extension point - allows modules to inject content-->
    @stack('landlord_settings_menu_10')

    <!--payment_gateways-->
    <li class="group-menu-wrapper {{ $page['inner_group_menu_billing'] ?? '' }}">
        <a class="inner-menu-item {{ $page['inner_group_menu_billing'] ?? '' }}" href="javascript:void(0);"
            aria-expanded="false">@lang('lang.payment_gateways')</a>
        <ul aria-expanded="false" class="hidden">
            <!--general-->
            <li>
                <a class="{{ $page['inner_menu_gateways'] ?? '' }}"
                    href="{{ url('app-admin/settings/gateways') }}">@lang('lang.general_settings')</a>
            </li>
            <!--stripe-->
            <li>
                <a class="{{ $page['inner_menu_stripe'] ?? '' }}"
                    href="{{ url('app-admin/settings/stripe') }}">Stripe</a>
            </li>
            <!--paypal-->
            <li>
                <a class="{{ $page['inner_menu_paypal'] ?? '' }}"
                    href="{{ url('app-admin/settings/paypal') }}">Paypal</a>
            </li>
            <!--paystack-->
            <li>
                <a class="{{ $page['inner_menu_paystack'] ?? '' }}"
                    href="{{ url('app-admin/settings/paystack') }}">Paystack</a>
            </li>
            <!--razorpay-->
            <li>
                <a class="{{ $page['inner_menu_razorpay'] ?? '' }}"
                    href="{{ url('app-admin/settings/razorpay') }}">Razorpay</a>
            </li>
            <!--offline-->
            <li>
                <a class="{{ $page['inner_menu_offline_payment'] ?? '' }}"
                    href="{{ url('app-admin/settings/offlinepayments') }}">@lang('lang.offline_payments')</a>
            </li>
        </ul>
    </li>

    <!--module extension point - allows modules to inject content-->
    @stack('landlord_settings_menu_11')

    <!--roles-->
    <li>
        <a class="inner-menu-item {{ $page['inner_menu_roles'] ?? '' }}"
            href="{{ url('app-admin/settings/roles') }}">@lang('lang.roles')</a>
    </li>

    <!--system-->
    <li>
        <a class="inner-menu-item {{ $page['inner_menu_system'] ?? '' }}"
            href="{{ url('app-admin/settings/system') }}">@lang('lang.system')</a>
    </li>

    <!--module extension point - allows modules to inject content-->
    @stack('landlord_settings_menu_12')

    <!--reCPATCH-->
    <li>
        <a class="inner-menu-item {{ $page['inner_menu_captcha'] ?? '' }}"
            href="{{ url('app-admin/settings/captcha') }}">reCAPTCHA</a>
    </li>

    <!--module extension point - allows modules to inject content-->
    @stack('landlord_settings_menu_13')

    <!--updates-->
    <li>
        <a class="inner-menu-item {{ $page['inner_menu_updates'] ?? '' }}"
            href="{{ url('app-admin/settings/updates') }}">@lang('lang.updates')</a>
    </li>

    <!--module extension point - allows modules to inject content-->
    @stack('landlord_settings_menu_')
    <!--debugging-->
    <li class="group-menu-wrapper {{ $page['inner_group_menu_debugging'] ?? '' }}">
        <a class="inner-menu-item {{ $page['inner_group_menu_debugging'] ?? '' }}" href="javascript:void(0);"
            aria-expanded="false">@lang('lang.debugging')</a>
        <ul aria-expanded="false" class="hidden">

            <!--maintenance mode-->
            <li>
                <a class="{{ $page['inner_menu_maintenance'] ?? '' }}"
                    href="{{ url('app-admin/settings/maintenance') }}">@lang('lang.maintenance_mode')</a>
            </li>

            <!--updates_log-->
            <li>
                <a class="{{ $page['inner_menu_updating_log'] ?? '' }}"
                    href="{{ url('app-admin/settings/updateslog') }}">@lang('lang.updates_log')</a>
            </li>
            <!--eror log-->
            <li>
                <a class="{{ $page['inner_menu_error_logs'] ?? '' }}"
                    href="{{ url('app-admin/settings/errorlogs') }}">@lang('lang.error_logs')</a>
            </li>

            <!--execute sql queries-->
            <li>
                <a class="{{ $page['inner_menu_execute_queries'] ?? '' }}"
                    href="{{ url('app-admin/settings/execute-queries') }}">@lang('lang.execute_sql_queries')</a>
            </li>
        </ul>
    </li>

    <!--module extension point - allows modules to inject content-->
    @stack('landlord_settings_menu_14')


</ul>