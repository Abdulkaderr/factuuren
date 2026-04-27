<!-- right-sidebar -->
<div class="right-sidebar" id="sidepanel-filter-leads">
    <form>
        <div class="slimscrollright">
            <!--title-->
            <div class="rpanel-title">
                <i class="icon-Filter-2"></i>{{ cleanLang(__('lang.filter_leads')) }}
                <span>
                    <i class="ti-close js-close-side-panels" data-target="sidepanel-filter-leads"></i>
                </span>
            </div>
            <!--title-->
            <!--body-->
            <div class="r-panel-body">


                <!--assigned-->
                @if(config('visibility.filter_panel_assigned'))
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.assigned_users')) }}
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
                                    @foreach(config('system.team_members') as $user)
                                    <option value="{{ $user->id }}" {{ in_array($user->id, $saved_assigned) ? 'selected' : '' }}>{{ $user->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <!--assigned-->

                <!--lead status-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.status')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $saved_status = config('filter.saved_data.filter_lead_status') ?? [];
                                if (!is_array($saved_status)) {
                                    $saved_status = [];
                                }
                                @endphp
                                <select name="filter_lead_status" id="filter_lead_status"
                                    class="form-control form-control-sm select2-basic select2-multiple select2-tags select2-hidden-accessible"
                                    multiple="multiple" tabindex="-1" aria-hidden="true">
                                    @foreach($statuses as $status)
                                    <option value="{{ $status->leadstatus_id }}" {{ in_array($status->leadstatus_id, $saved_status) ? 'selected' : '' }}>
                                        {{ runtimeLang($status->leadstatus_title) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!--lead status-->

                <!--date addded-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.date_added')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="filter_lead_created_start"
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="Start"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_lead_created_start') ?? '') }}">
                                <input class="mysql-date" type="hidden" id="filter_lead_created_start"
                                    name="filter_lead_created_start"
                                    value="{{ config('filter.saved_data.filter_lead_created_start') ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="filter_lead_created_end"
                                    class="form-control form-control-sm pickadate" placeholder="End"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_lead_created_end') ?? '') }}">
                                <input class="mysql-date" type="hidden" id="filter_lead_created_end"
                                    name="filter_lead_created_end"
                                    value="{{ config('filter.saved_data.filter_lead_created_end') ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <!--date added-->

                <!--last contacted-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.last_contact')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="filter_lead_last_contacted_start"
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="Start"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_lead_last_contacted_start') ?? '') }}">
                                <input class="mysql-date" type="hidden" id="filter_lead_last_contacted_start"
                                    name="filter_lead_last_contacted_start"
                                    value="{{ config('filter.saved_data.filter_lead_last_contacted_start') ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="filter_lead_last_contacted_end"
                                    class="form-control form-control-sm pickadate" autocomplete="off" placeholder="End"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_lead_last_contacted_end') ?? '') }}">
                                <input class="mysql-date" type="hidden" id="filter_lead_last_contacted_end"
                                    name="filter_lead_last_contacted_end"
                                    value="{{ config('filter.saved_data.filter_lead_last_contacted_end') ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <!--last contacted-->

                <!--value-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.value')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="number" class="form-control form-control-sm"
                                    placeholder="{{ cleanLang(__('lang.minimum')) }}" name="filter_lead_value_min"
                                    id="filter_lead_value_min"
                                    value="{{ config('filter.saved_data.filter_lead_value_min') ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control form-control-sm"
                                    placeholder="{{ cleanLang(__('lang.maximum')) }}" name="filter_lead_value_max"
                                    id="filter_lead_value_max"
                                    value="{{ config('filter.saved_data.filter_lead_value_max') ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <!--value-->

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

                <!--state-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.show')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <select class="select2-basic form-control form-control-sm select2-preselected" id="filter_lead_state"
                                    name="filter_lead_state"
                                    data-preselected="{{ config('filter.saved_data.filter_lead_state') ?? '' }}">
                                    <option value=""></option>
                                    <option value="active">@lang('lang.active_leads')</option>
                                    <option value="archived">@lang('lang.archives_leads')</option>
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
                    <a href="{{ url('/leads?clear-filter=yes') }}"
                        class="btn btn-rounded-x btn-secondary">@lang('lang.forget_filters')</a>
                    <input type="hidden" name="action" value="search">
                    <input type="hidden" name="source" value="{{ $page['source_for_filter_panels'] ?? '' }}">
                    <input type="hidden" name="query-type" value="filter">
                    <button type="button" class="btn btn-rounded-x btn-danger js-ajax-ux-request apply-filter-button"
                        data-url="{{ urlResource('/leads/search') }}" data-type="form"
                        data-ajax-type="GET">{{ cleanLang(__('lang.apply_filter')) }}</button>
                </div>


            </div>
            <!--body-->
        </div>
    </form>
</div>
<!--sidebar-->