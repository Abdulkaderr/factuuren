<!-- right-sidebar -->
<div class="right-sidebar" id="sidepanel-filter-clients">
    <form>
        <div class="slimscrollright">
            <!--title-->
            <div class="rpanel-title">
                <i class="icon-Filter-2"></i>{{ cleanLang(__('lang.filter_clients')) }}
                <span>
                    <i class="ti-close js-close-side-panels" data-target="sidepanel-filter-clients"></i>
                </span>
            </div>
            <!--title-->
            <!--body-->
            <div class="r-panel-body">

                <!--module extension point - allows modules to inject content-->
                @stack('filter_panel_1')

                <!--company name-->
                <div class="filter-block">
                    <div class="title">
                        @lang('lang.name')
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <!--select2 basic search-->
                                <select name="filter_client_id" id="filter_client_id"
                                    class="form-control form-control-sm js-select2-basic-search select2-multiple select2-hidden-accessible"
                                    multiple="multiple" tabindex="-1" aria-hidden="true"
                                    data-ajax--url="{{ url('/') }}/feed/company_names"></select>
                                <!--select2 basic search-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--company name-->

                <!--categories-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.category')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $saved_categories = config('filter.saved_data.filter_client_categoryid') ?? [];
                                if (!is_array($saved_categories)) {
                                $saved_categories = [];
                                }
                                @endphp
                                <select name="filter_client_categoryid" id="filter_client_categoryid"
                                    class="form-control form-control-sm select2-basic select2-multiple select2-hidden-accessible"
                                    multiple="multiple" tabindex="-1" aria-hidden="true">
                                    @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}"
                                        {{ in_array($category->category_id, $saved_categories) ? 'selected' : '' }}>
                                        {{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!--categories-->

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
                                    <option value="{{ $tag->tag_title }}"
                                        {{ in_array($tag->tag_title, $saved_tags) ? 'selected' : '' }}>
                                        {{ $tag->tag_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!--tags-->

                <!--filter item-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.date_created')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="filter_date_created_start"
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="{{ cleanLang(__('lang.start')) }}"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_date_created_start') ?? '') }}">
                                <input class="mysql-date" type="hidden" name="filter_date_created_start"
                                    id="filter_date_created_start"
                                    value="{{ config('filter.saved_data.filter_date_created_start') ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="filter_date_created_end" autocomplete="off"
                                    class="form-control form-control-sm pickadate"
                                    placeholder="{{ cleanLang(__('lang.end')) }}"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_date_created_end') ?? '') }}">
                                <input class="mysql-date" type="hidden" name="filter_date_created_end"
                                    id="filter_date_created_end"
                                    value="{{ config('filter.saved_data.filter_date_created_end') ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <!--filter item-->

                <!--status-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.status')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                @php
                                $saved_status = config('filter.saved_data.filter_client_status') ?? [];
                                if (!is_array($saved_status)) {
                                $saved_status = [];
                                }
                                @endphp
                                <select name="filter_client_status" id="filter_client_status"
                                    class="form-control form-control-sm select2-basic select2-multiple"
                                    multiple="multiple" tabindex="-1" aria-hidden="true">
                                    <option value="active" {{ in_array('active', $saved_status) ? 'selected' : '' }}>
                                        {{ cleanLang(__('lang.active')) }}</option>
                                    <option value="suspended"
                                        {{ in_array('suspended', $saved_status) ? 'selected' : '' }}>
                                        {{ cleanLang(__('lang.suspended')) }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!--status -->

                <!--module extension point - allows modules to inject content-->
                @stack('filter_panel_2')

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
                    <a href="{{ url('/clients?clear-filter=yes') }}"
                        class="btn btn-rounded-x btn-secondary">@lang('lang.forget_filters')</a>
                    <input type="hidden" name="action" value="search">
                    <input type="hidden" name="source" value="{{ $page['source_for_filter_panels'] ?? '' }}">
                    <input type="hidden" name="query-type" value="filter">
                    <button type="button" class="btn btn-rounded-x btn-danger js-ajax-ux-request apply-filter-button"
                        data-url="{{ urlResource('/clients/search') }}" data-type="form"
                        data-ajax-type="GET">{{ cleanLang(__('lang.apply_filter')) }}</button>
                </div>


            </div>
            <!--body-->
        </div>
    </form>
</div>
<!--sidebar-->