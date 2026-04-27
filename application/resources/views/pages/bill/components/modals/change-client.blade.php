<div class="row">
    <div class="col-12">

        <!--client-->
        <div class="form-group row">
            <label class="col-sm-12 text-left control-label col-form-label required">
                @lang('lang.client')*
            </label>
            <div class="col-sm-12">
                <!--select2 basic search-->
                <select name="bill_clientid" id="bill_clientid"
                    class="form-control form-control-sm js-select2-basic-search-modal select2-hidden-accessible"
                    data-ajax--url="{{ url('/') }}/feed/company_names">
                </select>
            </div>
        </div>

    </div>
</div>
