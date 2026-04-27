<!--module extension point-->
@stack('bill_position_29')
<div class="hidden payment-gateways" id="gateway-bank">

    <!--module extension point-->
    @stack('bill_position_30')

    <!--bank details-->
    <div class="gateway-bank-details p-t-10 p-b-10">
        {!! parseBankDetails(config('system.settings_bank_details'), $bill) !!}

        <!--module extension point-->
        @stack('bill_position_31')
    </div>

    <!--module extension point-->
    @stack('bill_position_32')
</div>