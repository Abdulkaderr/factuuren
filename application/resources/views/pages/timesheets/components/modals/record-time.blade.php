<div id="timesheet_rows_container" data-lang-remove="@lang('lang.remove')">
    <div class="timesheet-row p-3 m-b-40 border rounded" id="timesheet_row_default" data-row-id="default">

        @if(auth()->user()->is_admin && !is_numeric(request('task_id')))
        <div class="form-group row">
            <label class="col-12 text-left control-label col-form-label m-b-0 font-13 p-b-4">@lang('lang.team_member')</label>
            <div class="col-12">
                <select class="select2-basic form-control form-control-sm select2-preselected" id="timesheet_user_default"
                    data-base-url="{{ url('/feed/users-projects?user_id=') }}" name="timesheet_user[default]"
                    data-preselected="{{ auth()->user()->id }}">
                    @foreach(config('system.team_members') as $user)
                    <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @else
        <input type="hidden" name="timesheet_user[default]" value="{{ auth()->user()->id }}">
        @endif

        @if(is_numeric(request('task_id')))
        <input type="hidden" name="my_assigned_tasks[default]" value="{{ request('task_id') }}">
        <input type="hidden" name="source" value="tasks">
        @else
        <div class="form-group row">
            <div class="col-12 col-lg-6">
                <label class="text-left control-label col-form-label m-b-0 font-13 p-b-4">@lang('lang.projects')</label>
                <select name="my_assigned_projects[default]" id="my_assigned_projects_default" placeholder="project" data-user-id="{{ auth()->user()->id }}"
                    class="projects_my_tasks_toggle form-control form-control-sm js-select2-basic-search-modal"
                    data-task-dropdown="my_assigned_tasks_default"
                    data-ajax--url="{{ url('/feed/users-projects?user_id='.auth()->user()->id) }}"></select>
            </div>
            <div class="col-12 col-lg-6">
                <label class="text-left control-label col-form-label m-b-0 font-13 p-b-4">@lang('lang.tasks')</label>
                <select class="select2-basic form-control form-control-sm" id="my_assigned_tasks_default"
                    name="my_assigned_tasks[default]" disabled>
                </select>
            </div>
        </div>
        <input type="hidden" name="source" value="timesheets">
        @endif

        <div class="form-group row">
            <div class="col-12 col-lg-4">
                <label class="text-left control-label col-form-label m-b-0 font-13 p-b-4">@lang('lang.date')</label>
                <input type="text" class="form-control form-control-sm pickadate" disabled autocomplete="off"
                    name="timer_created_edit_default" id="manual_timer_created_default"
                    value="{{ runtimeDatepickerDate($estimate->bill_date ?? '') }}">
                <input class="mysql-date" type="hidden" name="timer_created[default]" id="timer_created_edit_default"
                    value="{{ $estimate->bill_date ?? '' }}">
            </div>
            <div class="col-6 col-lg-4">
                <label class="text-left control-label col-form-label m-b-0 font-13 p-b-4">@lang('lang.hrs')</label>
                <input type="number" class="form-control form-control-sm js-topnav-timer"
                    name="manual_time_hours[default]" id="manual_time_hours_default" disabled>
            </div>
            <div class="col-6 col-lg-4">
                <label class="text-left control-label col-form-label m-b-0 font-13 p-b-4">@lang('lang.mins')</label>
                <input type="number" class="form-control form-control-sm js-topnav-timer"
                    name="manual_time_minutes[default]" id="manual_time_minutes_default" disabled>
            </div>
        </div>

        <div class="form-group row dropdown-no-results-found hidden m-b-0" id="my_assigned_tasks_no_results_default">
            <div class="col-12 p-l-8 p-r-8">
                <span>@lang('lang.no_tasks_found')</span>
                <span class="align-middle p-l-5 font-16" data-toggle="tooltip"
                    title="@lang('lang.no_tasks_assigned_to_you')" data-placement="top"><i
                        class="ti-info-alt font-13"></i></span>
            </div>
        </div>
    </div>
</div>

<div class="text-center p-t-10 p-b-10">
    <button type="button" class="btn btn-sm btn-info" id="add_timesheet_row">
        <i class="ti-plus"></i> @lang('lang.add_another_time_record')
    </button>
</div>
