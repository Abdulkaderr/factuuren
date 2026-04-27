<div class="payment-gateways" id="gateway-flutterwave">
    <!--FLUTTERWAVE BUTTONS-->
    <div class="x-button">
        <a class="btn btn-danger disable-on-click-loading" href="{{ $checkout_url }}"  id="gateway-button-flutterwave">
            {{ cleanLang(__('lang.pay_now')) }} -
            {{ config('system.settings2_flutterwave_display_name') }}</a>
    </div>
</div>
