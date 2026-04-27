<!-- right-sidebar -->
<div class="right-sidebar" id="sidepanel-filter-projects">
    <form>
        <div class="slimscrollright">
            <!--title-->
            <div class="rpanel-title">
                <i class="icon-Filter-2"></i>{{ cleanLang(__('lang.filter_projects')) }}
                <span>
                    <i class="ti-close js-close-side-panels" data-target="sidepanel-filter-projects"></i>
                </span>
            </div>
            <!--title-->
            <!--body-->
            <div class="r-panel-body">

                <!--client-->
                @if(config('visibility.filter_panel_client_project'))
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.client_name')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <!--select2 basic search-->
                                @php
                                $client_data = config('filter.saved_data.filter_project_clientid');
                                $client_id = is_array($client_data) ? ($client_data['id'] ?? '') : ($client_data ?? '');
                                $client_text = is_array($client_data) ? ($client_data['text'] ?? '') : '';
                                @endphp
                                <select name="filter_project_clientid" id="filter_project_clientid"
                                    class="form-control form-control-sm js-select2-basic-search select2-hidden-accessible"
                                    data-ajax--url="{{ url('/') }}/feed/company_names"
                                    @if($client_id)
                                    data-filter-preselect-id="{{ $client_id }}"
                                    data-filter-preselect-text="{{ $client_text }}"
                                    @endif>
                                </select>
                                <!--select2 basic search-->
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <!--client-->

                <!--assigned-->
                @if(config('visibility.filter_panel_assigned'))
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.assigned')) }}
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

                <!--start date-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.start_date')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="filter_start_date_start"
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="{{ cleanLang(__('lang.start')) }}"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_start_date_start') ?? '') }}">
                                <input class="mysql-date" type="hidden" id="filter_start_date_start"
                                    name="filter_start_date_start" value="{{ config('filter.saved_data.filter_start_date_start') ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="filter_start_date_end"
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="{{ cleanLang(__('lang.end')) }}"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_start_date_end') ?? '') }}">
                                <input class="mysql-date" type="hidden" id="filter_start_date_end"
                                    name="filter_start_date_end" value="{{ config('filter.saved_data.filter_start_date_end') ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <!--start date-->


                <!--due date-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.due_date')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="filter_due_date_start"
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="{{ cleanLang(__('lang.start')) }}"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_due_date_start') ?? '') }}">
                                <input class="mysql-date" type="hidden" id="filter_due_date_start"
                                    name="filter_due_date_start" value="{{ config('filter.saved_data.filter_due_date_start') ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="filter_due_date_end"
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="{{ cleanLang(__('lang.end')) }}"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_due_date_end') ?? '') }}">
                                <input class="mysql-date" type="hidden" id="filter_due_date_end"
                                    name="filter_due_date_end" value="{{ config('filter.saved_data.filter_due_date_end') ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <!--due date-->

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

                <!--categorgies-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.category')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $saved_categories = config('filter.saved_data.filter_project_categoryid') ?? [];
                                if (!is_array($saved_categories)) {
                                    $saved_categories = [];
                                }
                                @endphp
                                <select name="filter_project_categoryid" id="filter_project_categoryid"
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

                <!--status-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.status')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $saved_statuses = config('filter.saved_data.filter_project_status') ?? [];
                                if (!is_array($saved_statuses)) {
                                    $saved_statuses = [];
                                }
                                @endphp
                                <select name="filter_project_status" id="filter_project_status"
                                    class="form-control form-control-sm select2-basic select2-multiple {{ runtimeAllowUserTags() }} select2-hidden-accessible"
                                    multiple="multiple" tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    @foreach(config('settings.project_statuses') as $key => $value)
                                    <option value="{{ $key }}" {{ in_array($key, $saved_statuses) ? 'selected' : '' }}>{{ runtimeLang($key) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!--status-->


                <!--state-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.show')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <select class="select2-basic form-control form-control-sm select2-preselected"
                                    id="filter_project_state" name="filter_project_state"
                                    data-preselected="{{ config('filter.saved_data.filter_project_state') ?? '' }}">
                                    <option value=""></option>
                                    <option value="active">@lang('lang.active_projects')</option>
                                    <option value="archived">@lang('lang.archives_projects')</option>
                                    <option value="all">@lang('lang.everything')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!--status -->
                    
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
                    <a href="{{ url('/projects?clear-filter=yes') }}"
                        class="btn btn-rounded-x btn-secondary">@lang('lang.forget_filters')</a>
                    <input type="hidden" name="action" value="search">
                    <input type="hidden" name="query-type" value="filter">
                    <input type="hidden" name="source" value="{{ $page['source_for_filter_panels'] ?? '' }}">
                    <button type="button" class="btn btn-rounded-x btn-danger js-ajax-ux-request apply-filter-button"
                        data-url="{{ urlResource('/projects/search') }}" data-type="form"
                        data-ajax-type="GET">{{ cleanLang(__('lang.apply_filter')) }}</button>
                </div>
            </div>
            <!--body-->
        </div>
    </form>
</div>
<!--sidebar-->