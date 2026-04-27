<!-- right-sidebar -->
<div class="right-sidebar" id="sidepanel-filter-proposals">
    <form>
        <div class="slimscrollright">
            <!--title-->
            <div class="rpanel-title">
                <i class="icon-Filter-2"></i>@lang('lang.filter_proposals')
                <span>
                    <i class="ti-close js-close-side-panels" data-target="sidepanel-filter-proposals"></i>
                </span>
            </div>

            <!--body-->
            <div class="r-panel-body">


                <!--client-->
                @if(config('visibility.filter_panel_client'))
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.client_name')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $client_data = config('filter.saved_data.filter_doc_client_id');
                                $client_id = is_array($client_data) ? ($client_data['id'] ?? '') : ($client_data ?? '');
                                $client_text = is_array($client_data) ? ($client_data['text'] ?? '') : '';
                                @endphp
                                <select name="filter_doc_client_id" id="filter_doc_client_id"
                                    class="form-control form-control-sm js-select2-basic-search-modal select2-hidden-accessible"
                                    data-ajax--url="{{ url('/') }}/feed/company_names"
                                    @if($client_id)
                                    data-filter-preselect-id="{{ $client_id }}"
                                    data-filter-preselect-text="{{ $client_text }}"
                                    @endif>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                @endif


                <!--lead-->
                @if(config('visibility.filter_panel_lead'))
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.lead')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $lead_data = config('filter.saved_data.filter_doc_lead_id');
                                $lead_id = is_array($lead_data) ? ($lead_data['id'] ?? '') : ($lead_data ?? '');
                                $lead_text = is_array($lead_data) ? ($lead_data['text'] ?? '') : '';
                                @endphp
                                <select name="filter_doc_lead_id" id="filter_doc_lead_id"
                                    class="form-control form-control-sm js-select2-basic-search-modal select2-hidden-accessible"
                                    data-ajax--url="{{ url('/') }}/feed/leadnames?ref=general"
                                    @if($lead_id)
                                    data-filter-preselect-id="{{ $lead_id }}"
                                    data-filter-preselect-text="{{ $lead_text }}"
                                    @endif>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!--categorgies-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.category')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $saved_categories = config('filter.saved_data.filter_proposal_categoryid') ?? [];
                                if (!is_array($saved_categories)) {
                                    $saved_categories = [];
                                }
                                @endphp
                                <select name="filter_proposal_categoryid" id="filter_proposal_categoryid"
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


                <!--proposal_date-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.proposal_date')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="filter_doc_date_start_start"
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="{{ cleanLang(__('lang.start')) }}"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_doc_date_start_start') ?? '') }}">
                                <input class="mysql-date" type="hidden" id="filter_doc_date_start_start"
                                    name="filter_doc_date_start_start"
                                    value="{{ config('filter.saved_data.filter_doc_date_start_start') ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="filter_doc_date_start_end"
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="{{ cleanLang(__('lang.end')) }}"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_doc_date_start_end') ?? '') }}">
                                <input class="mysql-date" type="hidden" id="filter_doc_date_start_end"
                                    name="filter_doc_date_start_end"
                                    value="{{ config('filter.saved_data.filter_doc_date_start_end') ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>


                <!--valid_until-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.valid_until')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="filter_doc_date_end_start"
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="{{ cleanLang(__('lang.start')) }}"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_doc_date_end_start') ?? '') }}">
                                <input class="mysql-date" type="hidden" id="filter_doc_date_end_start"
                                    name="filter_doc_date_end_start"
                                    value="{{ config('filter.saved_data.filter_doc_date_end_start') ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="filter_doc_date_end_end"
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="{{ cleanLang(__('lang.end')) }}"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_doc_date_end_end') ?? '') }}">
                                <input class="mysql-date" type="hidden" id="filter_doc_date_end_end"
                                    name="filter_doc_date_end_end"
                                    value="{{ config('filter.saved_data.filter_doc_date_end_end') ?? '' }}">
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
                    <a href="{{ url('/proposals?clear-filter=yes') }}"
                        class="btn btn-rounded-x btn-secondary">@lang('lang.forget_filters')</a>
                    <input type="hidden" name="query-type" value="filter">
                    <input type="hidden" name="action" value="search">
                    <input type="hidden" name="source" value="{{ $page['source_for_filter_panels'] ?? '' }}">
                    <button type="button" class="btn btn-rounded-x btn-danger js-ajax-ux-request apply-filter-button"
                        data-url="{{ urlResource('/proposals/search') }}" data-type="form"
                        data-ajax-type="GET">{{ cleanLang(__('lang.apply_filter')) }}</button>
                </div>
            </div>
            <!--body-->
        </div>
    </form>
</div>
<!--sidebar-->