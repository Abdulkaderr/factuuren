<!--filtered results warning-->
@if(config('filter.status') == 'active')
<div class="filtered-results-warning opacity-8 p-b-5">
    <small>
        @lang('lang.these_results_are')
        <a href="javascript:void(0);" class="js-toggle-side-panel" data-target="sidepanel-filter-leads">@lang('lang.filtered')</a>.
        @lang('lang.you_can')
        <a href="{{ url('/leads?clear-filter=yes') }}">@lang('lang.clear_the_filters')</a>.
    </small>
</div>
@endif

<div class="boards count-{{ @count($leads ?? []) }} js-trigger-leads-kanban-board" id="leads-view-wrapper" data-position="{{ url('leads/update-position') }}">
    <!--each board-->
    @foreach($boards as $board)
    <!--board-->
    @include('pages.leads.components.kanban.board')
    @endforeach
</div>