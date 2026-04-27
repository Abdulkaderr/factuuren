<!-- right-sidebar -->
<div class="right-sidebar" id="sidepanel-filter-tickets">
    <form>
        <div class="slimscrollright">
            <!--title-->
            <div class="rpanel-title">
                <i class="icon-Filter-2"></i>{{ cleanLang(__('lang.filter_tickets')) }}
                <span>
                    <i class="ti-close js-close-side-panels" data-target="sidepanel-filter-tickets"></i>
                </span>
            </div>
            <!--title-->
            <!--body-->
            <div class="r-panel-body">

                <!--company name-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.client_name')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $client_data = config('filter.saved_data.filter_ticket_clientid');
                                $client_id = is_array($client_data) ? ($client_data['id'] ?? '') : ($client_data ?? '');
                                $client_text = is_array($client_data) ? ($client_data['text'] ?? '') : '';
                                @endphp
                                <select name="filter_ticket_clientid" id="filter_ticket_clientid"
                                    class="clients_and_projects_toggle form-control form-control-sm js-select2-basic-search select2-hidden-accessible"
                                    data-projects-dropdown="filter_ticket_projectid"
                                    data-feed-request-type="filter_tickets"
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
                                $project_data = config('filter.saved_data.filter_ticket_projectid');
                                $project_id = is_array($project_data) ? ($project_data['id'] ?? '') : ($project_data ?? '');
                                $project_text = is_array($project_data) ? ($project_data['text'] ?? '') : '';
                                @endphp
                                <select
                                    class="select2-basic form-control form-control-sm dynamic_filter_ticket_projectid js-select2-dynamic-project"
                                    id="filter_ticket_projectid" name="filter_ticket_projectid" disabled
                                    @if($project_id)
                                    data-filter-preselect-id="{{ $project_id }}"
                                    data-filter-preselect-text="{{ $project_text }}"
                                    @endif>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!--category-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.category')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $saved_categories = config('filter.saved_data.filter_ticket_categoryid') ?? [];
                                if (!is_array($saved_categories)) {
                                    $saved_categories = [$saved_categories];
                                }
                                @endphp
                                <select name="filter_ticket_categoryid" id="filter_ticket_categoryid"
                                    class="form-control form-control-sm select2-basic select2-multiple select2-hidden-accessible"
                                    multiple="multiple" tabindex="-1" aria-hidden="true">
                                    @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}" {{ in_array($category->category_id, $saved_categories) ? 'selected' : '' }}>
                                        {{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


                <!--date-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.date')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="filter_ticket_created_start"
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="Start"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_ticket_created_start') ?? '') }}">
                                <input class="mysql-date" type="hidden" name="filter_ticket_created_start"
                                    id="filter_ticket_created_start"
                                    value="{{ config('filter.saved_data.filter_ticket_created_start') ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="filter_ticket_created_end"
                                    class="form-control form-control-sm pickadate" autocomplete="off" placeholder="End"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_ticket_created_end') ?? '') }}">
                                <input class="mysql-date" type="hidden" name="filter_ticket_created_end"
                                    id="filter_ticket_created_end"
                                    value="{{ config('filter.saved_data.filter_ticket_created_end') ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>


                <!--priority-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.priority')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $saved_priority = config('filter.saved_data.filter_ticket_priority') ?? [];
                                if (!is_array($saved_priority)) {
                                    $saved_priority = [$saved_priority];
                                }
                                @endphp
                                <select class="select2-basic form-control form-control-sm" id="filter_ticket_priority"
                                    name="filter_ticket_priority" multiple="multiple" tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    @foreach(config('settings.ticket_priority') as $key => $value)
                                    <option value="{{ $key }}" {{ in_array($key, $saved_priority) ? 'selected' : '' }}>{{ runtimeLang($key) }}</option>
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
                                $saved_statuses = config('filter.saved_data.filter_ticket_status') ?? [];
                                if (!is_array($saved_statuses)) {
                                    $saved_statuses = [$saved_statuses];
                                }
                                @endphp
                                <select class="select2-basic form-control form-control-sm" id="filter_ticket_status"
                                    name="filter_ticket_status" multiple="multiple" tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    @foreach($statuses as $status)
                                    <option value="{{ $status->ticketstatus_id }}" {{ in_array($status->ticketstatus_id, $saved_statuses) ? 'selected' : '' }}>{{
                                        runtimeLang($status->ticketstatus_title) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


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

                <!--custom fields-->
                @include('misc.customfields-filters')

                <!--show archived tickets-->
                <div class="filter-block">
                    <div class="fields">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group form-group-checkbox">
                                    @php
                                    $saved_show_archive = config('filter.saved_data.show_archive_tickets') ?? '';
                                    @endphp
                                    <input type="checkbox" id="show_archive_tickets" name="show_archive_tickets"
                                        class="filled-in chk-col-light-blue"
                                        {{ $saved_show_archive == 'on' ? 'checked' : '' }}>
                                    <label class="p-l-30" for="show_archive_tickets">@lang('lang.show_archive_tickets')</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                    <a href="{{ url('/tickets?clear-filter=yes') }}"
                        class="btn btn-rounded-x btn-secondary">@lang('lang.forget_filters')</a>
                    <input type="hidden" name="query-type" value="filter">
                    <input type="hidden" name="action" value="search">
                    <input type="hidden" name="source" value="{{ $page['source_for_filter_panels'] ?? '' }}">
                    <button type="button" class="btn btn-rounded-x btn-danger js-ajax-ux-request apply-filter-button"
                        data-url="{{ urlResource('/tickets/search?') }}" data-type="form"
                        data-ajax-type="GET">{{ cleanLang(__('lang.apply_filter')) }}</button>
                </div>


            </div>
            <!--body-->
        </div>
    </form>
</div>
<!--sidebar-->