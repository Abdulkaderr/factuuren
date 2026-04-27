<div class="form-group row">
    <label for="example-month-input" class="col-12 col-form-label text-left">{{ cleanLang(__('lang.move_invoices_to_status')) }}</label>
    <div class="col-sm-12">
        <select class="select2-basic form-control form-control-sm" id="invoices_status" name="invoices_status">
            @foreach($statuses as $status)
            <option value="{{ $status->invoicestatus_id }}">{{ $status->invoicestatus_title }}</option>
            @endforeach
        </select>
    </div>
</div>
