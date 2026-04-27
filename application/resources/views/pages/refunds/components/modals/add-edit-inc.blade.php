<!--add/edit refund modal form-->
<div id="refund-add-edit-wrapper">

    @if(isset($page) && $page['response'] == 'create')
    <!--create mode: payment id text input-->
    <div class="form-group row">
        <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">
            @lang('lang.payment_id')
        </label>
        <div class="col-sm-12 col-lg-9">
            <input type="number" class="form-control form-control-sm"
                id="refund_paymentid" name="refund_paymentid"
                value="{{ old('refund_paymentid') }}">
        </div>
    </div>
    @endif

    @if(!isset($page) || $page['response'] != 'create')
    <!--edit mode: show amount as read-only-->
    <div class="form-group row">
        <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">
            @lang('lang.amount')
        </label>
        <div class="col-sm-12 col-lg-9">
            <span class="form-control form-control-sm bg-light">{{ runtimeMoneyFormat($refund->refund_amount ?? 0) }}</span>
        </div>
    </div>
    @endif

    <!--refund date (required)-->
    <div class="form-group row">
        <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">
            @lang('lang.refund_date')
        </label>
        <div class="col-sm-12 col-lg-9">
            <input type="text" class="form-control form-control-sm pickadate"
                autocomplete="off" name="refund_date"
                value="{{ runtimeDatepickerDate($refund->refund_date ?? '') }}">
            <input class="mysql-date" type="hidden" name="refund_date" id="refund_date"
                value="{{ $refund->refund_date ?? runtimeTodaysDateMySQL() }}">
        </div>
    </div>

    <!--notes (optional)-->
    <div class="form-group row">
        <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">
            @lang('lang.notes')
        </label>
        <div class="col-sm-12 col-lg-9">
            <textarea class="form-control form-control-sm" rows="4"
                name="refund_notes" id="refund_notes">{{ $refund->refund_notes ?? '' }}</textarea>
        </div>
    </div>

</div>
<!--add/edit refund modal form-->
