<!-- right-sidebar -->
<div class="right-sidebar" id="sidepanel-filter-expenses">
    <form>
        <div class="slimscrollright">
            <!--title-->
            <div class="rpanel-title">
                <i class="icon-Filter-2"></i>{{ cleanLang(__('lang.filter_expenses')) }}
                <span>
                    <i class="ti-close js-close-side-panels" data-target="sidepanel-filter-expenses"></i>
                </span>
            </div>
            <!--title-->
            <!--body-->
            <div class="r-panel-body">


                <!--filter by team members-->
                @if(config('visibility.filter_by_user'))
                <div class="filter-block">
                    <div class="title">
                        @lang('lang.team_member')
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $saved_creators = config('filter.saved_data.filter_expense_creatorid_list') ?? [];
                                if (!is_array($saved_creators)) {
                                    $saved_creators = [];
                                }
                                @endphp
                                <select name="filter_expense_creatorid_list" id="filter_expense_creatorid_list"
                                    data-allow-clear="true"
                                    class="form-control  form-control-sm select2-basic select2-multiple select2-hidden-accessible"
                                    multiple="multiple" tabindex="-1" aria-hidden="true">
                                    <option></option>
                                    @foreach(config('system.team_members') as $user)
                                    <option value="{{ $user->id }}" {{ in_array($user->id, $saved_creators) ? 'selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }}
                                    </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>
                </div>
                @endif



                <!--company name-->
                @if(config('visibility.filter_panel_client'))
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.client_name')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $client_data = config('filter.saved_data.filter_expense_clientid');
                                $client_id = is_array($client_data) ? ($client_data['id'] ?? '') : ($client_data ?? '');
                                $client_text = is_array($client_data) ? ($client_data['text'] ?? '') : '';
                                @endphp
                                <select name="filter_expense_clientid" id="filter_expense_clientid"
                                    class="clients_and_projects_toggle form-control form-control-sm js-select2-basic-search select2-hidden-accessible"
                                    data-projects-dropdown="filter_expense_projectid"
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
                @endif

                <!--project-->
                @if(config('visibility.filter_panel_project'))
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.project')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $project_data = config('filter.saved_data.filter_expense_projectid');
                                $project_id = is_array($project_data) ? ($project_data['id'] ?? '') : ($project_data ?? '');
                                $project_text = is_array($project_data) ? ($project_data['text'] ?? '') : '';
                                @endphp
                                <select class="select2-basic form-control form-control-sm dynamic_expense_projectid js-select2-dynamic-project"
                                    id="filter_expense_projectid" name="filter_expense_projectid" disabled
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

                <!--clients project list-->
                @if(config('visibility.filter_panel_clients_projects'))
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.project')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <select class="select2-basic form-control form-control-sm" id="filter_expense_projectid"
                                    name="filter_expense_projectid">
                                    <option></option>
                                    @foreach($projects as $project)
                                    <option value="{{ $project->project_id }}">{{ $project->project_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!--amount-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.amount')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-6 input-group input-group-sm">
                                <span
                                    class="input-group-addon">{{ config('system.settings_system_currency_symbol') }}</span>
                                <input type="number" name="filter_expense_amount_min" id="filter_expense_amount_min"
                                    class="form-control form-control-sm"
                                    placeholder="{{ cleanLang(__('lang.minimum')) }}"
                                    value="{{ config('filter.saved_data.filter_expense_amount_min') ?? '' }}">
                            </div>
                            <div class="col-md-6 input-group input-group-sm">
                                <span
                                    class="input-group-addon">{{ config('system.settings_system_currency_symbol') }}</span>
                                <input type="number" name="filter_expense_amount_max" id="filter_expense_amount_max"
                                    class="form-control form-control-sm"
                                    placeholder="{{ cleanLang(__('lang.maximum')) }}"
                                    value="{{ config('filter.saved_data.filter_expense_amount_max') ?? '' }}">
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
                                <input type="text" name="filter_expense_date_start"
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="{{ cleanLang(__('lang.start')) }}"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_expense_date_start') ?? '') }}">
                                <input class="mysql-date" type="hidden" id="filter_expense_date_start"
                                    name="filter_expense_date_start"
                                    value="{{ config('filter.saved_data.filter_expense_date_start') ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="filter_expense_date_end"
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="{{ cleanLang(__('lang.end')) }}"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_expense_date_end') ?? '') }}">
                                <input class="mysql-date" type="hidden" id="filter_expense_date_end"
                                    name="filter_expense_date_end"
                                    value="{{ config('filter.saved_data.filter_expense_date_end') ?? '' }}">
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
                                $saved_categories = config('filter.saved_data.filter_expense_categoryid') ?? [];
                                if (!is_array($saved_categories)) {
                                    $saved_categories = [];
                                }
                                @endphp
                                <select name="filter_expense_categoryid" id="filter_expense_categoryid"
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
                    <a href="{{ url('/expenses?clear-filter=yes') }}"
                        class="btn btn-rounded-x btn-secondary">@lang('lang.forget_filters')</a>
                    <input type="hidden" name="query-type" value="filter">
                    <input type="hidden" name="action" value="search">
                    <input type="hidden" name="source" value="{{ $page['source_for_filter_panels'] ?? '' }}">
                    <button type="button" class="btn btn-rounded-x btn-danger js-ajax-ux-request apply-filter-button"
                        data-url="{{ urlResource('/expenses/search') }}" data-type="form"
                        data-ajax-type="GET">{{ cleanLang(__('lang.apply_filter')) }}</button>
                </div>
            </div>
            <!--body-->
        </div>
    </form>
</div>
<!--sidebar-->