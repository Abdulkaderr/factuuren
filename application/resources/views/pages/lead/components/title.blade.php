<div class="card-top-nav-actions">
    <!--star button-->
    <span title="{{ cleanLang(__('lang.star_lead')) }}"
        class="star-button data-toggle-action-tooltip opacity-4 ajax-request {{ $lead->is_starred ? 'hidden' : '' }} starred-star-button-{{ $lead->lead_id }}"
        id="starred-star-button-{{ $lead->lead_id }}"
        data-url="{{ url('/starred/togglestatus?action=star&resource_type=lead&resource_id='.$lead->lead_id) }}"
        data-loading-target="starred-star-button-{{ $lead->lead_id }}" data-ajax-type="POST"
        data-on-start-submit-button="disable">
        <i class="sl-icon-star"></i>
    </span>

    <!--unstar button-->
    <span title="{{ cleanLang(__('lang.unstar_lead')) }}"
        class="star-button data-toggle-action-tooltip ajax-request text-warning {{ !$lead->is_starred ? 'hidden' : '' }} starred-unstar-button-{{ $lead->lead_id }}"
        id="starred-unstar-button-{{ $lead->lead_id }}"
        data-url="{{ url('/starred/togglestatus?action=unstar&resource_type=lead&resource_id='.$lead->lead_id) }}"
        data-loading-target="starred-unstar-button-{{ $lead->lead_id }}" data-ajax-type="POST"
        data-on-start-submit-button="disable">
        <i class="sl-icon-star"></i>
    </span>

    <!--distraction free mode: enable button (shown when pref is 'no')-->
    <span title="@lang('lang.distraction_free_mode')"
        class="data-toggle-action-tooltip opacity-4 ajax-request cursor-pointer p-l-5 {{ distractionFreeModeCheck('enable') }}"
        id="task_distraction_free_enable_btn" data-url="{{ url('/user/distraction-free-mode?action=enable') }}"
        data-loading-target="task_distraction_free_enable_btn" data-ajax-type="POST"
        data-on-start-submit-button="disable">
        <i class="sl-icon-size-fullscreen"></i>
    </span>

    <!--distraction free mode: disable button (shown when pref is 'yes')-->
    <span title="@lang('lang.distraction_free_mode')"
        class="data-toggle-action-tooltip ajax-request text-warning cursor-pointer p-l-5 {{ distractionFreeModeCheck('disable') }}"
        id="task_distraction_free_disable_btn" data-url="{{ url('/user/distraction-free-mode?action=disable') }}"
        data-loading-target="task_distraction_free_disable_btn" data-ajax-type="POST"
        data-on-start-submit-button="disable">
        <i class="sl-icon-size-fullscreen"></i>
    </span>
</div>

<div class="card-title" id="{{ runtimePermissions('lead-edit-title', $lead->permission_edit_lead) }}">
    {{ $lead->lead_title }}
</div>


<!--buttons: edit-->
@if($lead->permission_edit_lead)
<div id="card-title-edit" class="card-title-edit hidden">
    <input type="text" class="form-control form-control-sm card-title-input" id="lead_title" name="lead_title">
    <!--button: subit & cancel-->
    <div id="card-title-submit" class="p-t-10 text-right">
        <button type="button" class="btn waves-effect waves-light btn-xs btn-default"
            id="card-title-button-cancel">{{ cleanLang(__('lang.cancel')) }}</button>
        <button type="button" class="btn waves-effect waves-light btn-xs btn-danger"
            data-url="{{ url('/leads/'.$lead->lead_id.'/update-title') }}" data-progress-bar='hidden' data-type="form"
            data-form-id="card-title-edit" data-ajax-type="post"
            id="card-title-button-save">{{ cleanLang(__('lang.save')) }}</button>
    </div>
</div>
@endif

<!--this item is archived notice-->
@if(runtimeArchivingOptions())
<div id="card_archived_notice_{{ $lead->lead_id }}"
    class="alert alert-warning p-t-7 p-b-7 {{ runtimeActivateOrAchive('archived-notice', $lead->lead_active_state) }}">
    <i class="mdi mdi-archive"></i> @lang('lang.this_lead_is_archived')
</div>
@endif