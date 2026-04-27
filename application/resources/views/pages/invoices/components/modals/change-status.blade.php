<div class="row" id="change-status-form-wrapper">
    <div class="col-lg-12">
        <!--new status-->
        <div class="form-group row">
            <label class="col-12 text-left control-label col-form-label required">@lang('lang.new_status')*</label>
            <div class="col-12">
                <select class="select2-basic form-control form-control-sm select2-preselected"
                    id="bill_status" name="bill_status" data-width="element"
                    data-preselected="{{ $invoice->bill_status ?? '' }}">
                    <option></option>
                    @foreach($statuses as $status)
                    <option value="{{ $status->invoicestatus_id }}">{{ $status->invoicestatus_title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
