<!--create tasks modal-->

@if(!$has_project)

<!--notice: estimate not attached to a project-->
<div class="alert alert-info m-t-10">
    <i class="ti-info-alt m-r-5"></i> @lang('lang.create_tasks_requires_project')
</div>

@else

<!--info panel-->
<div class="alert alert-info m-b-15">
    <i class="ti-info-alt m-r-5"></i> @lang('lang.create_tasks_from_lineitems_info')
</div>

<!--line items table-->
<div class="form-group row">
    <div class="col-12">
        <table class="table table-bordered m-b-0">
            <thead>
                <tr>
                    <th class="w-px-30"></th>
                    <th>@lang('lang.description')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lineitems as $lineitem)
                <tr>
                    <!--checkbox - disabled if already converted, pre-selected otherwise-->
                    <td class="text-center">
                        @if(in_array($lineitem->lineitem_uniqueid, $converted_lineitem_ids))
                        <input type="checkbox"
                            id="lineitem_{{ $lineitem->lineitem_uniqueid }}"
                            name="selected_lineitems[]"
                            value="{{ $lineitem->lineitem_uniqueid }}"
                            class="filled-in chk-col-light-blue"
                            checked="checked"
                            disabled="disabled">
                        <label for="lineitem_{{ $lineitem->lineitem_uniqueid }}"></label>
                        @else
                        <input type="checkbox"
                            id="lineitem_{{ $lineitem->lineitem_uniqueid }}"
                            name="selected_lineitems[]"
                            value="{{ $lineitem->lineitem_uniqueid }}"
                            class="filled-in chk-col-light-blue"
                            checked="checked">
                        <label for="lineitem_{{ $lineitem->lineitem_uniqueid }}"></label>
                        @endif
                    </td>
                    <!--line item description-->
                    <td>{{ $lineitem->lineitem_description }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center">@lang('lang.no_results_found')</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!--milestone (required)-->
<div class="form-group row">
    <label class="col-12 text-left control-label col-form-label required">
        @lang('lang.milestone')
    </label>
    <div class="col-12">
        <select class="select2-basic form-control form-control-sm select2-preselected"
            id="milestone_id" name="milestone_id" data-width="element"
            data-preselected="{{ $milestones->first()->milestone_id ?? '' }}">
            <option value="">@lang('lang.select')</option>
            @foreach($milestones as $milestone)
            <option value="{{ $milestone->milestone_id }}">{{ $milestone->milestone_title }}</option>
            @endforeach
        </select>
    </div>
</div>

<!--task status (required)-->
<div class="form-group row">
    <label class="col-12 text-left control-label col-form-label required">
        @lang('lang.status')
    </label>
    <div class="col-12">
        <select class="select2-basic form-control form-control-sm select2-preselected"
            id="task_status" name="task_status" data-width="element"
            data-preselected="{{ $statuses->first()->taskstatus_id ?? '' }}">
            <option value="">@lang('lang.select')</option>
            @foreach($statuses as $status)
            <option value="{{ $status->taskstatus_id }}">{{ runtimeLang($status->taskstatus_title) }}</option>
            @endforeach
        </select>
    </div>
</div>

<!--assign team members (optional)-->
<div class="form-group row">
    <label class="col-12 text-left control-label col-form-label">
        @lang('lang.assign_users')
    </label>
    <div class="col-12">
        <select name="assigned" id="assigned"
            class="form-control form-control-sm select2-basic select2-multiple select2-tags"
            data-width="element" multiple="multiple">
            @foreach($team_users as $user)
            <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
            @endforeach
        </select>
    </div>
</div>

<!--previously converted notice (only shown when at least one line item is disabled)-->
@if($disabled_lineitem_count > 0)
<div class="alert alert-warning m-t-15 m-b-0">
    <i class="ti-info-alt m-r-5"></i> @lang('lang.create_tasks_previously_converted')
</div>
@endif

@endif
<!--/create tasks modal-->
