<!--heading section with sorting dropdown-->
<div
    class="p-t-10 p-b-10 p-r-10 p-l-10 bg-contrast border-radius-5 m-b-50 d-flex align-items-center justify-content-between">

    <!--heading-->
    <span class="font-weight-400 font-16 position-relative"><span
            class="display-inline-block m-r-8 vertical-align-middle"><i class="sl-icon-call-in"></i></span>
        <span class="display-inline-block">@lang('lang.leads')</span></span>

    <!--sort by dropdown-->
    <div class="dropdown">
        <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="starredSortDropdown"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @lang('lang.sort_by'):
            <span id="starred-sort-text">
                @if(request('orderby') == 'lead_last_contacted')
                @lang('lang.last_contacted')
                @elseif(request('orderby') == 'lead_value')
                @lang('lang.value')
                @else
                @lang('lang.lead_title')
                @endif
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="starredSortDropdown">
            <a class="dropdown-item js-ajax-ux-request js-starred-sorting" href="javascript:void(0)"
                data-url="{{ url('/starred/view/leads?orderby=lead_title&sortorder=asc') }}"
                data-loading-target="sidepanel-starred-container" data-target="sidepanel-starred-container"
                data-sort-text="@lang('lang.lead_title')" data-progress-bar='hidden'>@lang('lang.lead_title')</a>
            <a class="dropdown-item js-ajax-ux-request js-starred-sorting" href="javascript:void(0)"
                data-url="{{ url('/starred/view/leads?orderby=lead_last_contacted&sortorder=desc') }}"
                data-loading-target="sidepanel-starred-container" data-target="sidepanel-starred-container"
                data-sort-text="@lang('lang.last_contacted')" data-progress-bar='hidden'>@lang('lang.last_contacted')</a>
            <a class="dropdown-item js-ajax-ux-request js-starred-sorting" href="javascript:void(0)"
                data-url="{{ url('/starred/view/leads?orderby=lead_value&sortorder=desc') }}"
                data-loading-target="sidepanel-starred-container" data-target="sidepanel-starred-container"
                data-sort-text="@lang('lang.value')" data-progress-bar='hidden'>@lang('lang.value')</a>
        </div>
    </div>

</div>

@if(isset($leads) && count($leads) > 0)
@foreach($leads as $lead)
<div class="card m-b-2 bg-contrast border-radius-8 m-b-30 starred-feed-item"
    id="starred-item-{{ $lead->starred_uniqueid ?? '' }}">
    <div class="card-body p-t-10 p-b-10">
        <div class="d-flex align-items-center justify-content-between m-b-5">
            <div class="flex-grow-1 ajax-request url-link cursor-pointer" data-url="{{ url('/leads/v/'.$lead->lead_id.'/view') }}">
                <span class="text-muted">@lang('lang.lead'): </span><span
                    class="font-weight-500">{{ $lead->lead_title }}</span>
            </div>
            <div class="dropdown">
                <button class="btn btn-sm p-0 font-18 text-muted" type="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item js-ajax-ux-request js-starred-remove-item" href="javascript:void(0)"
                        data-url="{{ url('/starred/remove/'.$lead->starred_uniqueid) }}" data-progress-bar='hidden'
                        data-item-id="starred-item-{{ $lead->starred_uniqueid ?? '' }}"
                        data-progress-bar="hidden"
                        data-type="delete" data-ajax-type="delete">@lang('lang.remove_from_list')</a>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center ajax-request url-link cursor-pointer"
            data-url="{{ url('/leads/'.$lead->lead_id) }}">
            <span class="text-muted">@lang('lang.contact'):</span>
            <span class="label label-outline-info m-l-5">{{ $lead->lead_firstname }} {{ $lead->lead_lastname }}</span>
        </div>
        <a href="{{ url('/leads/'.$lead->lead_id) }}"
            class="d-flex align-items-start flex-column m-t-10 text-reset text-decoration-none">
            <div class="font-12 m-b-5">
                <span class="text-muted">@lang('lang.last_contacted'):</span>
                <span class="font-weight-500">{{ runtimeDate($lead->lead_last_contacted) }}</span>
            </div>
            <div class="font-12 m-b-5">
                <span class="text-muted">@lang('lang.value'):</span>
                <span class="font-weight-500">{{ runtimeMoneyFormat($lead->lead_value) }}</span>
            </div>
            @if($lead->leadstatus)
            <div class="font-12">
                <span class="text-muted">@lang('lang.status'):</span>
                <span class="label {{ bootstrapColors($lead->leadstatus->leadstatus_color ?? '', 'label') }} m-l-5">{{ runtimeLang($lead->leadstatus->leadstatus_title ?? '---') }}</span>
            </div>
            @endif
        </a>
    </div>
</div>
@endforeach
@else
<div class="text-center p-t-40 p-b-40">
    <img src="{{ url('/') }}/public/images/no-results-found.png" alt="@lang('lang.no_results_found')" height="80">
    <h4 class="m-t-20">@lang('lang.no_results_found')</h4>
</div>
@endif
