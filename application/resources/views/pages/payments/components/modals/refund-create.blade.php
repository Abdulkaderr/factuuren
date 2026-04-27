<!--refund create form (opened from payments list page)-->
<div id="payment-refund-create-wrapper">

    <!--hidden: payment id-->
    <input type="hidden" name="refund_paymentid" value="{{ $payment->payment_id }}">

    <!--amount (read-only)-->
    <div class="form-group row">
        <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">
            @lang('lang.amount')
        </label>
        <div class="col-sm-12 col-lg-9">
            <span class="form-control form-control-sm bg-light">{{ runtimeMoneyFormat($payment->payment_amount) }}</span>
        </div>
    </div>

    <!--refund date (required)-->
    <div class="form-group row">
        <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">
            @lang('lang.refund_date')
        </label>
        <div class="col-sm-12 col-lg-9">
            <input type="text" class="form-control form-control-sm pickadate"
                autocomplete="off" name="refund_date"
                value="{{ runtimeDatepickerDate('') }}">
            <input class="mysql-date" type="hidden" name="refund_date" id="refund_date"
                value="{{ runtimeTodaysDateMySQL() }}">
        </div>
    </div>

    <!--notes (optional)-->
    <div class="form-group row">
        <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">
            @lang('lang.notes')
        </label>
        <div class="col-sm-12 col-lg-9">
            <textarea class="form-control form-control-sm" rows="4"
                name="refund_notes" id="refund_notes"></textarea>
        </div>
    </div>

</div>
<!--refund create form-->
