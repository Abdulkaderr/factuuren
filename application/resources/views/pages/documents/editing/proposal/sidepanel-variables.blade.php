<!-- right-sidebar -->
<div class="right-sidebar documents-side-panel-variables sidebar-xl" id="documents-side-panel-variables">
    <form>
        <div class="slimscrollright">
            <!--title-->
            <div class="rpanel-title">
                <!--add class'due'to title panel -->
                <i class="ti-write display-inline-block m-t--5"></i>
                <div class="display-inline-block">
                    @lang('lang.variables')
                </div>
                <span>
                    <i class="ti-close js-close-side-panels" data-target="documents-side-panel-variables"
                        id="documents-side-panel-variables-close-icon"></i>
                </span>
            </div>
            <!--title-->
            <!--body-->
            <div class="r-panel-body documents-side-panel-variables-body  p-b-80"
                id="documents-side-panel-variables-body">

                <div class="alert alert-info">
                    @lang('lang.variables_instruction')
                </div>

                <ul class="x-ducument-variables-list">
                    <li>{proposal_id}</li>
                    <li>{title}</li>
                    <li>{proposal_date}</li>
                    <li>{expiry_date}</li>
                    <li>{prepared_by_name}</li>
                    <li>{pricing_table}</li>
                    <li>{pricing_total}</li>
                    <li>{todays_date}</li>
                </ul>

            </div>
            <!--body-->
        </div>
    </form>
</div>
<!--sidebar-->