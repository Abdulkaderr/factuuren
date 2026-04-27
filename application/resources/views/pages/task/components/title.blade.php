<div class="card-top-nav-actions">
    <!--star button-->
    <span title="{{ cleanLang(__('lang.star_task')) }}"
        class="star-button data-toggle-action-tooltip opacity-4 ajax-request {{ $task->is_starred ? 'hidden' : '' }} starred-star-button-{{ $task->task_id }}"
        id="starred-star-button-{{ $task->task_id }}"
        data-url="{{ url('/starred/togglestatus?action=star&resource_type=task&resource_id='.$task->task_id) }}"
        data-loading-target="starred-star-button-{{ $task->task_id }}"
        data-ajax-type="POST"
        data-on-start-submit-button="disable">
        <i class="sl-icon-star"></i>
    </span>

    <!--unstar button-->
    <span title="{{ cleanLang(__('lang.unstar_task')) }}"
        class="star-button data-toggle-action-tooltip ajax-request text-warning {{ !$task->is_starred ? 'hidden' : '' }} starred-unstar-button-{{ $task->task_id }}"
        id="starred-unstar-button-{{ $task->task_id }}"
        data-url="{{ url('/starred/togglestatus?action=unstar&resource_type=task&resource_id='.$task->task_id) }}"
        data-loading-target="starred-unstar-button-{{ $task->task_id }}"
        data-ajax-type="POST"
        data-on-start-submit-button="disable">
        <i class="sl-icon-star"></i>
    </span>

    <!--distraction free mode: enable button (shown when pref is 'no')-->
    <span title="@lang('lang.distraction_free_mode')"
        class="data-toggle-action-tooltip opacity-4 ajax-request cursor-pointer p-l-5 {{ distractionFreeModeCheck('enable') }}"
        id="task_distraction_free_enable_btn"
        data-url="{{ url('/user/distraction-free-mode?action=enable') }}"
        data-loading-target="task_distraction_free_enable_btn"
        data-ajax-type="POST"
        data-on-start-submit-button="disable">
        <i class="sl-icon-size-fullscreen"></i>
    </span>

    <!--distraction free mode: disable button (shown when pref is 'yes')-->
    <span title="@lang('lang.distraction_free_mode')"
        class="data-toggle-action-tooltip ajax-request text-warning cursor-pointer p-l-5 {{ distractionFreeModeCheck('disable') }}"
        id="task_distraction_free_disable_btn"
        data-url="{{ url('/user/distraction-free-mode?action=disable') }}"
        data-loading-target="task_distraction_free_disable_btn"
        data-ajax-type="POST"
        data-on-start-submit-button="disable">
        <i class="sl-icon-size-fullscreen"></i>
    </span>
</div>

<div class="card-title m-b-0">
    <span id="{{ runtimePermissions('task-edit-title', $task->permission_edit_task) }}"> {{ $task->task_title }}
    </span>
</div>
<!--buttons: edit-->
@if($task->permission_edit_task)
<div id="card-title-edit" class="card-title-edit hidden">
    <input type="text" class="form-control form-control-sm card-title-input" id="task_title" name="task_title">
    <!--button: subit & cancel-->
    <div id="card-title-submit" class="p-t-10 text-right">
        <button type="button" class="btn waves-effect waves-light btn-xs btn-default"
            id="card-title-button-cancel">{{ cleanLang(__('lang.cancel')) }}</button>
        <button type="button" class="btn waves-effect waves-light btn-xs btn-danger"
            data-url="{{ urlResource('/tasks/'.$task->task_id.'/update-title') }}" data-progress-bar='hidden'
            data-type="form" data-form-id="card-title-edit" data-ajax-type="post"
            id="card-title-button-save">{{ cleanLang(__('lang.save')) }}</button>
    </div>
</div>
@endif
<div class="m-b-5">
    <div><small><strong>@lang('lang.project'): </strong></small><small id="card-task-project-title"><a
                href="{{ url('projects/'.$task->project_id ?? '') }}">{{ $task->project_title ?? '---' }}</a></small>
    </div>
    <div><small><strong>@lang('lang.milestone'): </strong></small><small
            id="card-task-milestone-title">{{ runtimeLang($task->milestone_title, 'task_milestone') }}</small></div>

    <!--module extension point - allows modules to inject content-->
    @stack('section_task_left_panel_title')
</div>
<!--this item is archived notice-->
@if(runtimeArchivingOptions())
<div id="card_archived_notice_{{ $task->task_id }}"
    class="alert alert-warning p-t-7 p-b-7 {{ runtimeActivateOrAchive('archived-notice', $task->task_active_state) }}">
    <i class="mdi mdi-archive"></i> @lang('lang.this_task_is_archived')
</div>
@endif