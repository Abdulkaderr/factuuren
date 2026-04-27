<div class="card count-{{ @count($tasks ?? []) }}" id="tasks-view-wrapper">
    <div class="card-body">
        <!--filtered results warning-->
        @if(config('filter.status') == 'active')
        <div class="filtered-results-warning opacity-8 p-b-0 p-l-20 p-t-10">
            <small>
                @lang('lang.these_results_are')
                <a href="javascript:void(0);" class="js-toggle-side-panel"
                    data-target="sidepanel-filter-tasks">@lang('lang.filtered')</a>.
                @lang('lang.you_can')
                <a href="{{ url('/tasks?clear-filter=yes') }}">@lang('lang.clear_the_filters')</a>.
            </small>
        </div>
        @endif
        <div class="table-responsive list-table-wrapper">
            @if (@count($tasks ?? []) > 0)
            <table id="tasks-list-table" class="table m-t-0 m-b-0 table-hover no-wrap contact-list" data-page-size="10"
                data-url="{{ url('/') }}/tasks/timer-poll/" data-type="form" data-ajax-type="post"
                data-form-id="tasks-list-table">
                <!--module extension point - allows modules to inject content-->
                @stack('table_1')
                <thead>
                    <tr>
                        <th class="tasks_col_title">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_task_title" href="javascript:void(0)"
                                data-url="{{ urlResource('/tasks?action=sort&orderby=task_title&sortorder=asc') }}">{{ cleanLang(__('lang.title')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>
                        @if(config('visibility.tasks_col_project'))
                        <th class="tasks_col_title">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_task_project"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/tasks?action=sort&orderby=task_project&sortorder=asc') }}">{{ cleanLang(__('lang.project')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>
                        @endif
                        @if(config('visibility.tasks_col_milestone'))
                        <th class="tasks_col_milestone">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_milestone" href="javascript:void(0)"
                                data-url="{{ urlResource('/tasks?action=sort&orderby=milestone&sortorder=asc') }}">{{ cleanLang(__('lang.milestone')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>
                        @endif
                        @if(config('visibility.tasks_col_date'))
                        <th class="tasks_col_added">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_task_date" href="javascript:void(0)"
                                data-url="{{ urlResource('/tasks?action=sort&orderby=task_date&sortorder=asc') }}">{{ cleanLang(__('lang.created')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>
                        @endif
                        <th class="tasks_col_deadline">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_task_date_due"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/tasks?action=sort&orderby=task_date_due&sortorder=asc') }}">{{ cleanLang(__('lang.deadline')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>
                        @if(config('visibility.tasks_col_assigned'))
                        <th class="tasks_col_assigned"><a
                                href="javascript:void(0)">{{ cleanLang(__('lang.assigned')) }}</a></th>
                        @endif
                        @if(config('visibility.tasks_col_all_time'))
                        <th class="tasks_col_all_time"><a class="js-ajax-ux-request js-list-sorting" id="sort_mytime"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/tasks?action=sort&orderby=mytime&sortorder=asc') }}">{{ cleanLang(__('lang.all_time')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        @endif
                        @if(config('visibility.tasks_col_mytime'))
                        <th class="tasks_col_my_time"><a class="js-ajax-ux-request js-list-sorting" id="sort_mytime"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/tasks?action=sort&orderby=mytime&sortorder=asc') }}">{{ cleanLang(__('lang.my_time')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        @endif
                        @if(config('visibility.tasks_col_priority'))
                        <th class="tasks_col_priority">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_task_priority"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/tasks?action=sort&orderby=task_priority&sortorder=asc') }}">{{ cleanLang(__('lang.priority')) }}#<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>
                        @endif
                        @if(config('visibility.tasks_col_tags'))
                        <th class="tasks_col_tags"><a href="javascript:void(0)">{{ cleanLang(__('lang.tags')) }}</a>
                        </th>
                        @endif
                        <th class="tasks_col_status">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_task_status"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/tasks?action=sort&orderby=task_status&sortorder=asc') }}">{{ cleanLang(__('lang.status')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>
                        <th class="tasks_col_action"><a href="javascript:void(0)">{{ cleanLang(__('lang.action')) }}</a>

                            <!--module extension point - allows modules to inject content-->
                            @stack('table_2')

                        </th>
                    </tr>
                </thead>
                <!--module extension point - allows modules to inject content-->
                @stack('table_3')
                <tbody id="tasks-td-container">
                    <!--ajax content here-->
                    @include('pages.tasks.components.table.ajax')
                    <!--ajax content here-->
                </tbody>
                <!--module extension point - allows modules to inject content-->
                @stack('table_4')
                <tfoot>
                    <tr>
                        <td colspan="20">
                            <!--load more button-->
                            @include('misc.load-more-button')
                            <!--load more button-->
                        </td>
                    </tr>
                </tfoot>
                <!--module extension point - allows modules to inject content-->
                @stack('table_5')
            </table>
            @endif
            @if (@count($tasks ?? []) == 0)
            <!--nothing found-->
            @include('notifications.no-results-found')
            <!--nothing found-->
            @endif
        </div>
    </div>
</div>