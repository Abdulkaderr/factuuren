<!--heading section with sorting dropdown-->
<div
    class="p-t-10 p-b-10 p-r-10 p-l-10 bg-contrast border-radius-5 m-b-50 d-flex align-items-center justify-content-between">

    <!--heading-->
    <span class="font-weight-400 font-16 position-relative"><span
            class="display-inline-block m-r-8 vertical-align-middle"><i class="ti-receipt"></i></span>
        <span class="display-inline-block">@lang('lang.estimates')</span></span>

    <!--sort by dropdown-->
    <div class="dropdown">
        <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="starredSortDropdown"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @lang('lang.sort_by'):
            <span id="starred-sort-text">
                @if(request('orderby') == 'bill_expiry_date')
                @lang('lang.expiry_date')
                @elseif(request('orderby') == 'bill_final_amount')
                @lang('lang.amount')
                @else
                @lang('lang.estimate_date')
                @endif
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="starredSortDropdown">
            <a class="dropdown-item js-ajax-ux-request js-starred-sorting" href="javascript:void(0)"
                data-url="{{ url('/starred/view/estimates?orderby=bill_date&sortorder=desc') }}"
                data-loading-target="sidepanel-starred-container" data-target="sidepanel-starred-container"
                data-sort-text="@lang('lang.estimate_date')" data-progress-bar='hidden'>@lang('lang.estimate_date')</a>
            <a class="dropdown-item js-ajax-ux-request js-starred-sorting" href="javascript:void(0)"
                data-url="{{ url('/starred/view/estimates?orderby=bill_expiry_date&sortorder=desc') }}"
                data-loading-target="sidepanel-starred-container" data-target="sidepanel-starred-container"
                data-sort-text="@lang('lang.expiry_date')" data-progress-bar='hidden'>@lang('lang.expiry_date')</a>
            <a class="dropdown-item js-ajax-ux-request js-starred-sorting" href="javascript:void(0)"
                data-url="{{ url('/starred/view/estimates?orderby=bill_final_amount&sortorder=desc') }}"
                data-loading-target="sidepanel-starred-container" data-target="sidepanel-starred-container"
                data-sort-text="@lang('lang.amount')" data-progress-bar='hidden'>@lang('lang.amount')</a>
        </div>
    </div>

</div>

@if(isset($estimates) && count($estimates) > 0)
@foreach($estimates as $estimate)
<div class="card m-b-2 bg-contrast border-radius-8 m-b-30 starred-feed-item"
    id="starred-item-{{ $estimate->starred_uniqueid ?? '' }}">
    <div class="card-body p-t-10 p-b-10">
        <div class="d-flex align-items-center justify-content-between m-b-5">
            <div class="flex-grow-1 ajax-request url-link cursor-pointer" data-url="{{ url('/estimates/'.$estimate->bill_estimateid) }}">
                <span class="text-muted">@lang('lang.client'): </span><span
                    class="font-weight-500">{{ $estimate->client->client_company_name ?? '---' }}</span>
            </div>
            <div class="dropdown">
                <button class="btn btn-sm p-0 font-18 text-muted" type="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item js-ajax-ux-request js-starred-remove-item" href="javascript:void(0)"
                        data-url="{{ url('/starred/remove/'.$estimate->starred_uniqueid) }}" data-progress-bar='hidden'
                        data-item-id="starred-item-{{ $estimate->starred_uniqueid ?? '' }}"
                        data-progress-bar="hidden"
                        data-type="delete" data-ajax-type="delete">@lang('lang.remove_from_list')</a>
                </div>
            </div>
        </div>
        @if($estimate->project)
        <div class="d-flex align-items-center ajax-request url-link cursor-pointer"
            data-url="{{ url('/estimates/'.$estimate->bill_estimateid) }}">
            <span class="text-muted">@lang('lang.project'):</span>
            <span class="m-l-5">{{ $estimate->project->project_title ?? '---' }}</span>
        </div>
        @endif
        <a href="{{ url('/estimates/'.$estimate->bill_estimateid) }}"
            class="d-flex align-items-start justify-content-between m-t-10 text-reset text-decoration-none">
            <div>
                <div class="font-12 m-b-5">
                    <span class="text-muted">@lang('lang.estimate_date'):</span>
                    <span class="font-weight-500">{{ runtimeDate($estimate->bill_date) }}</span>
                </div>
                <div class="font-12 m-b-5">
                    <span class="text-muted">@lang('lang.expiry_date'):</span>
                    <span class="font-weight-500">{{ runtimeDate($estimate->bill_expiry_date) }}</span>
                </div>
                <div class="font-12 m-b-5">
                    <span class="text-muted">@lang('lang.amount'):</span>
                    <span class="font-weight-500">{{ runtimeMoneyFormat($estimate->bill_final_amount) }}</span>
                </div>
            </div>
            <div class="font-12 text-right">
                <div class="m-b-5">
                    <span class="font-weight-500">@lang('lang.client_viewed')</span>
                </div>
                <div>
                    @if($estimate->bill_viewed_by_client == 'yes')
                    <span class="label label-light-success">@lang('lang.yes')</span>
                    @else
                    <span class="label label-light-danger">@lang('lang.no')</span>
                    @endif
                </div>
            </div>
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
