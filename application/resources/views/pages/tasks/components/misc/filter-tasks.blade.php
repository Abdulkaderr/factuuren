<!-- right-sidebar -->
<div class="right-sidebar" id="sidepanel-filter-tasks">
    <form>
        <div class="slimscrollright">
            <!--title-->
            <div class="rpanel-title">
                <i class="icon-Filter-2"></i>{{ cleanLang(__('lang.filter_tasks')) }}
                <span>
                    <i class="ti-close js-close-side-panels" data-target="sidepanel-filter-tasks"></i>
                </span>
            </div>
            <!--title-->
            <!--body-->
            <div class="r-panel-body">

                <!--module extension point - allows modules to inject content-->
                @stack('filter_panel_1')

                @if(config('visibility.filter_panel_client_project'))
                <!--company name-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.client_name')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $client_data = config('filter.saved_data.filter_task_clientid');
                                $client_id = is_array($client_data) ? ($client_data['id'] ?? '') : ($client_data ?? '');
                                $client_text = is_array($client_data) ? ($client_data['text'] ?? '') : '';
                                @endphp
                                <select name="filter_task_clientid" id="filter_task_clientid"
                                    class="clients_and_projects_toggle form-control form-control-sm js-select2-basic-search select2-hidden-accessible"
                                    data-projects-dropdown="filter_task_projectid"
                                    data-feed-request-type="clients_projects"
                                    data-ajax--url="{{ url('/') }}/feed/company_names"
                                    @if($client_id)
                                    data-filter-preselect-id="{{ $client_id }}"
                                    data-filter-preselect-text="{{ $client_text }}"
                                    @endif></select>
                            </div>
                        </div>
                    </div>
                </div>

                <!--project-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.project')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $project_data = config('filter.saved_data.filter_task_projectid');
                                $project_id = is_array($project_data) ? ($project_data['id'] ?? '') : ($project_data ?? '');
                                $project_text = is_array($project_data) ? ($project_data['text'] ?? '') : '';
                                @endphp
                                <select class="select2-basic form-control form-control-sm dynamic_filter_task_projectid js-select2-dynamic-project" data-allow-clear="true"
                                    id="filter_task_projectid" name="filter_task_projectid" disabled
                                    @if($project_id)
                                    data-filter-preselect-id="{{ $project_id }}"
                                    data-filter-preselect-text="{{ $project_text }}"
                                    @endif>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!--task type (when viewing a project)-->
                @if(config('visibility.tasks_filter_milestone'))
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.milestone')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $saved_milestones = config('filter.saved_data.filter_task_milestoneid') ?? [];
                                if (!is_array($saved_milestones)) {
                                    $saved_milestones = [];
                                }
                                @endphp
                                <select name="filter_task_milestoneid" id="filter_task_milestoneid"
                                    class="form-control  form-control-sm select2-basic select2-multiple select2-hidden-accessible"
                                    multiple="multiple" tabindex="-1" aria-hidden="true">
                                    @if(isset($milestones))
                                    @foreach($milestones as $milestone)
                                    <option value="{{ $milestone->milestone_id }}" {{ in_array($milestone->milestone_id, $saved_milestones) ? 'selected' : '' }}>
                                        {{ runtimeLang($milestone->milestone_title, 'task_milestone') }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                @endif


                <!--assigned-->
                @if(config('visibility.filter_panel_assigned'))
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.assigned_to')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $saved_assigned = config('filter.saved_data.filter_assigned') ?? [];
                                if (!is_array($saved_assigned)) {
                                    $saved_assigned = [];
                                }
                                @endphp
                                <select name="filter_assigned" id="filter_assigned"
                                    class="form-control form-control-sm select2-basic select2-multiple select2-tags select2-hidden-accessible"
                                    multiple="multiple" tabindex="-1" aria-hidden="true">
                                    <!--users list-->
                                    @foreach(config('system.team_members') as $user)
                                    <option value="{{ $user->id }}" {{ in_array($user->id, $saved_assigned) ? 'selected' : '' }}>{{ $user->full_name }}</option>
                                    @endforeach
                                    <!--/#users list-->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!--date added-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.date_added')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="filter_task_date_start_start" autocomplete="off"
                                    class="form-control form-control-sm pickadate" placeholder="Start"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_task_date_start_start') ?? '') }}">
                                <input class="mysql-date" type="hidden" name="filter_task_date_start_start"
                                    id="filter_task_date_start_start" value="{{ config('filter.saved_data.filter_task_date_start_start') ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="filter_task_date_start_end" autocomplete="off"
                                    class="form-control form-control-sm pickadate" placeholder="End"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_task_date_start_end') ?? '') }}">
                                <input class="mysql-date" type="hidden" name="filter_task_date_start_end"
                                    id="filter_task_date_start_end" value="{{ config('filter.saved_data.filter_task_date_start_end') ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!--date due-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.due_date')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="filter_task_date_due_start"
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="Start"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_task_date_due_start') ?? '') }}">
                                <input class="mysql-date" type="hidden" name="filter_task_date_due_start"
                                    id="filter_task_date_due_start" value="{{ config('filter.saved_data.filter_task_date_due_start') ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="filter_task_date_due_end"
                                    class="form-control form-control-sm pickadate" autocomplete="off" placeholder="End"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_task_date_due_end') ?? '') }}">
                                <input class="mysql-date" type="hidden" name="filter_task_date_due_end"
                                    id="filter_task_date_due_end" value="{{ config('filter.saved_data.filter_task_date_due_end') ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <!--filter item-->
                <!--tags-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.tags')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $saved_tags = config('filter.saved_data.filter_tags') ?? [];
                                if (!is_array($saved_tags)) {
                                    $saved_tags = [];
                                }
                                @endphp
                                <select name="filter_tags" id="filter_tags"
                                    class="form-control form-control-sm select2-multiple {{ runtimeAllowUserTags() }} select2-hidden-accessible"
                                    multiple="multiple" tabindex="-1" aria-hidden="true">
                                    @foreach($tags as $tag)
                                    <option value="{{ $tag->tag_title }}" {{ in_array($tag->tag_title, $saved_tags) ? 'selected' : '' }}>
                                        {{ $tag->tag_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!--tags-->


                <!--priority-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.priority')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $saved_priority = config('filter.saved_data.filter_task_priority') ?? [];
                                if (!is_array($saved_priority)) {
                                    $saved_priority = [];
                                }
                                @endphp
                                <select name="filter_task_priority" id="filter_task_priority"
                                    class="form-control  form-control-sm select2-basic select2-multiple select2-hidden-accessible"
                                    multiple="multiple" tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    @foreach($priorities as $priority)
                                    <option value="{{ $priority->taskpriority_id }}" {{ in_array($priority->taskpriority_id, $saved_priority) ? 'selected' : '' }}>{{ $priority->taskpriority_title }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!--status-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.status')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $saved_status = config('filter.saved_data.filter_tasks_status') ?? [];
                                if (!is_array($saved_status)) {
                                    $saved_status = [];
                                }
                                @endphp
                                <select name="filter_tasks_status" id="filter_tasks_status"
                                    class="form-control  form-control-sm select2-basic select2-multiple select2-hidden-accessible"
                                    multiple="multiple" tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    @foreach(config('task_statuses') as $task_status)
                                    <option value="{{ $task_status->taskstatus_id }}" {{ in_array($task_status->taskstatus_id, $saved_status) ? 'selected' : '' }}>
                                        {{ runtimeLang($task_status->taskstatus_title) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!--has pending checklists-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.has_pending_checklists')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <select class="select2-basic form-control form-control-sm select2-preselected" id="filter_task_pending_checklists"
                                    name="filter_task_pending_checklists"
                                    data-preselected="{{ config('filter.saved_data.filter_task_pending_checklists') ?? '' }}">
                                    <option value=""></option>
                                    <option value="yes">@lang('lang.yes')</option>
                                    <option value="no">@lang('lang.no')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!--state-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.show')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <select class="select2-basic form-control form-control-sm select2-preselected" id="filter_task_state"
                                    name="filter_task_state"
                                    data-preselected="{{ config('filter.saved_data.filter_task_state') ?? '' }}">
                                    <option value=""></option>
                                    <option value="active">@lang('lang.active_tasks')</option>
                                    <option value="archived">@lang('lang.archives_tasks')</option>
                                    <option value="all">@lang('lang.everything')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!--status -->

                <!--module extension point - allows modules to inject content-->
                @stack('filter_panel_2')

                <!--custom fields-->
                @include('misc.customfields-filters')

                <!--remember filters-->
                <div class="modal-selector m-t-20 p-b-0 p-l-35 p-t-20">
                    <div class="filter-block">
                        <div class="fields">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group form-group-checkbox m-b-0">
                                        <input type="checkbox" id="filter_remember" name="filter_remember"
                                            class="filled-in chk-col-light-blue"
                                            {{ config('filter.status') == 'active' ? 'checked' : '' }}>
                                        <label class="p-l-30"
                                            for="filter_remember">@lang('lang.remember_filters')</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--buttons-->
                <div class="buttons-block">
                    <a href="{{ url('/tasks?clear-filter=yes') }}"
                        class="btn btn-rounded-x btn-secondary">@lang('lang.forget_filters')</a>
                    <input type="hidden" name="query-type" value="filter">
                    <input type="hidden" name="action" value="search">
                    <input type="hidden" name="source" value="{{ $page['source_for_filter_panels'] ?? '' }}">
                    <button type="button" class="btn btn-rounded-x btn-danger js-ajax-ux-request apply-filter-button"
                        data-url="{{ urlResource('/tasks/search?') }}" data-type="form"
                        data-ajax-type="GET">{{ cleanLang(__('lang.apply_filter')) }}</button>
                </div>

            </div>
            <!--body-->
        </div>
    </form>
</div>
<!--sidebar-->