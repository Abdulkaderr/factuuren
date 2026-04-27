<div class="table-responsive">

    @if(@count($logs ?? []) > 0)
    <!--log records table-->
    <table class="table m-t-0 m-b-0 table-hover no-wrap table-sortable" id="error-logs-table">
        <thead>
            <tr>
                <th><a href="javascript:void(0)">@lang('lang.date')<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                <th><a href="javascript:void(0)">@lang('lang.type')<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                <th><a href="javascript:void(0)">@lang('lang.description')<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                <th><a href="javascript:void(0)">@lang('lang.actions')</a></th>
            </tr>
        </thead>
        <tbody id="error-logs-td-container">
            <!--log rows-->
            @include('landlord.customer.errorlogs.ajax')
            <!--/log rows-->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">
                    <!--load more button-->
                    @include('landlord.misc.load-more-button')
                    <!--/load more button-->
                </td>
            </tr>
        </tfoot>
    </table>
    <!--/log records table-->
    @endif

    @if(@count($logs ?? []) == 0)
    <!--no records-->
    @include('notifications.no-results-found')
    <!--/no records-->
    @endif

</div>
