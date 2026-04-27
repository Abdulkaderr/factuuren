<div class="boards count-{{ @count($tasks ?? []) }}" id="tasks-view-wrapper">
    <!--filtered results warning-->
    @if(config('filter.status') == 'active')
    <div class="filtered-results-warning opacity-8 p-b-5">
        <small>
            @lang('lang.these_results_are')
            <a href="javascript:void(0);" class="js-toggle-side-panel" data-target="sidepanel-filter-tasks">@lang('lang.filtered')</a>.
            @lang('lang.you_can')
            <a href="{{ url('/tasks?clear-filter=yes') }}">@lang('lang.clear_the_filters')</a>.
        </small>
    </div>
    @endif
    <!--each board-->
    @foreach($boards as $board)
    <!--board-->
    @include('pages.tasks.components.kanban.board')
    @endforeach
</div>
<!--ajax element-->
<span class="hidden" data-url=""></span>

<!--filter-->
@if(auth()->user()->is_team)
@include('pages.tasks.components.misc.filter-tasks')
@endif
<!--filter-->

<!--export-->
@if(config('visibility.list_page_actions_exporting'))
@include('pages.export.tasks.export')
@endif