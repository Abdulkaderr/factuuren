<!--check list - select gateway-->
<div class="p-t-25 invoice-pay text-right hidden" id="invoice-pay-container">
    <div class="x-title" id="invoice-pay-title-select-method">{{ cleanLang(__('lang.select_payment_method')) }}</div>
    <div class="x-options" id="invoice-pay-options-container">

        <!--module extension point-->
        @stack('bill_position_25')

        <!--stripe-->
        @if(config('system.settings_stripe_status') == 'enabled')
        <div class="x-checkbox">
            <label class="x-label">{{ config('system.settings_stripe_display_name') }}</label>
            <input name="group5" type="radio" id="radio_payment_stripe" data-gateway-id="gateway-stripe"
                data-url="{{ url('invoices/'.$bill->bill_invoiceid.'/stripe-payment') }}"
                class="invoice-pay-gateway-selector with-gap radio-col-green">
            <label for="radio_payment_stripe">&nbsp;</label>
        </div>
        @endif
        <!--razorpay-->
        @if(config('system.settings_razorpay_status') == 'enabled')
        <div class="x-checkbox">
            <label class="x-label">{{ config('system.settings_razorpay_display_name') }}</label>
            <input name="group5" type="radio" id="radio_payment_razorpay" data-gateway-id="gateway-razorpay"
                data-url="{{ url('invoices/'.$bill->bill_invoiceid.'/razorpay-payment') }}"
                class="invoice-pay-gateway-selector with-gap radio-col-green">
            <label for="radio_payment_razorpay">&nbsp;</label>
        </div>
        @endif
        <!--paypal-->
        @if(config('system.settings_paypal_status') == 'enabled')
        <div class="x-checkbox">
            <label class="x-label">{{ config('system.settings_paypal_display_name') }}</label>
            <input name="group5" type="radio" id="radio_payment_paypal" data-gateway-id="gateway-paypal"
                data-url="{{ url('invoices/'.$bill->bill_invoiceid.'/paypal-payment') }}"
                class="invoice-pay-gateway-selector with-gap radio-col-green">
            <label for="radio_payment_paypal">&nbsp;</label>
        </div>
        @endif
        <!--mollie-->
        @if(config('system.settings_mollie_status') == 'enabled')
        <div class="x-checkbox">
            <label class="x-label">{{ config('system.settings_mollie_display_name') }}</label>
            <input name="group5" type="radio" id="radio_payment_mollie" data-gateway-id="gateway-mollie"
                data-button-id="gateway-mollie"
                data-url="{{ url('invoices/'.$bill->bill_invoiceid.'/mollie-payment') }}"
                class="invoice-pay-gateway-selector with-gap radio-col-green">
            <label for="radio_payment_mollie">&nbsp;</label>
        </div>
        @endif
        <!--tap-->
        @if(config('system.settings2_tap_status') == 'enabled')
        <div class="x-checkbox">
            <label class="x-label">{{ config('system.settings2_tap_display_name') }}</label>
            <input name="group5" type="radio" id="radio_payment_tap" data-gateway-id="gateway-tap"
                data-button-id="gateway-tap" data-url="{{ url('invoices/'.$bill->bill_invoiceid.'/tap-payment') }}"
                class="invoice-pay-gateway-selector with-gap radio-col-green">
            <label for="radio_payment_tap">&nbsp;</label>
        </div>
        @endif

        <!--paystack-->
        @if(config('system.settings2_paystack_status') == 'enabled')
        <div class="x-checkbox">
            <label class="x-label">{{ config('system.settings2_paystack_display_name') }}</label>
            <input name="group5" type="radio" id="radio_payment_paystack" data-gateway-id="gateway-paystack"
                data-button-id="gateway-tap" data-url="{{ url('invoices/'.$bill->bill_invoiceid.'/paystack-payment') }}"
                class="invoice-pay-gateway-selector with-gap radio-col-green">
            <label for="radio_payment_paystack">&nbsp;</label>
        </div>
        @endif

        <!--flutterwave-->
        @if(config('system.settings2_flutterwave_status') == 'enabled')
        <div class="x-checkbox">
            <label class="x-label">{{ config('system.settings2_flutterwave_display_name') }}</label>
            <input name="group5" type="radio" id="radio_payment_flutterwave" data-gateway-id="gateway-flutterwave"
                data-button-id="gateway-flutterwave" data-url="{{ url('invoices/'.$bill->bill_invoiceid.'/flutterwave-payment') }}"
                class="invoice-pay-gateway-selector with-gap radio-col-green">
            <label for="radio_payment_flutterwave">&nbsp;</label>
        </div>
        @endif

        <!--bank-->
        @if(config('system.settings_bank_status') == 'enabled')
        <div class="x-checkbox">
            <label class="x-label">{{ config('system.settings_bank_display_name') }}</label>
            <input name="group5" type="radio" id="radio_payment_bank" data-gateway-id="gateway-bank"
                class="invoice-pay-gateway-selector with-gap radio-col-green">
            <label for="radio_payment_bank">&nbsp;</label>
        </div>
        @endif
    </div>

    <!--module extension point-->
    @stack('bill_position_26')

    <!--PAYMENT BUTTONS-->
    <div id="invoice-paynow-buttons-wrapper">
        <!--module extension point-->
        @stack('bill_position_27')
        <div class="x-title hidden p-b-20" id="invoice-pay-title-complete-payment">
            {{ cleanLang(__('lang.complete_your_payment')) }}
        </div>
        <!--module extension point-->
        @stack('bill_position_28')
        <div id="invoice-paynow-buttons-container">
            <!--please wait-->
            @include('pages.pay.pleasewait')

            <!--payment details - bank-->
            @if(config('system.settings_bank_status') == 'enabled')
            @include('pages.pay.bank')
            @endif
        </div>
    </div>
</div>