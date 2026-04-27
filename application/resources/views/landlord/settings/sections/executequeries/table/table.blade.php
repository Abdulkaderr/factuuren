<div class="table-responsive">
    @if (@count($queries ?? []) > 0)
    <table id="execute-queries-table" class="table m-t-0 m-b-0 table-hover no-wrap contact-list execute-queries-table" data-page-size="10">
        <thead>
            <tr>
                <th>@lang('lang.date')</th>
                <th>@lang('lang.unique_id')</th>
                <th>@lang('lang.title')</th>
                <th>@lang('lang.passed')</th>
                <th>@lang('lang.errors')</th>
                <th>@lang('lang.total')</th>
                <th>@lang('lang.status')</th>
                <th>@lang('lang.actions')</th>
            </tr>
        </thead>
        <tbody>
            @include('landlord.settings.sections.executequeries.table.ajax')
        </tbody>
    </table>
    @endif
    @if (@count($queries ?? []) == 0)
    @include('notifications.no-results-found')
    @endif
</div>
