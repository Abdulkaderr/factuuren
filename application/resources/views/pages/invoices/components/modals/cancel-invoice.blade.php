<!-- cancel invoice form -->
<div id="cancel-invoice-wrapper">

    <!-- cancellation reason -->
    <div class="form-group row">
        <label class="col-12 text-left control-label col-form-label required">
            @lang('lang.cancellation_reason')
        </label>
        <div class="col-12 p-r-4">
            <textarea class="form-control form-control-sm tinymce-textarea"
                rows="5"
                name="html_bill_cancellation_reasons"
                id="html_bill_cancellation_reasons"></textarea>
        </div>
    </div>

    <!-- refund payments (only shown when invoice has payments) -->
    @if($has_payments)
    <div class="form-group form-group-checkbox row">
        <div class="col-12">
            <label class="text-left control-label col-form-label p-r-3">@lang('lang.refund_all_payments')</label>
            <span class="text-right p-l-3">
                <input type="checkbox" id="refund_payments" name="refund_payments"
                    class="filled-in chk-col-light-blue" value="yes">
                <label for="refund_payments" class="display-inline"></label>
            </span>
        </div>
    </div>
    @endif

</div>
