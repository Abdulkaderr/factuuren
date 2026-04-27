<!--filter side panel-->
<div class="right-sidebar" id="sidepanel-filter-refunds">
    <form>
        <div class="slimscrollright">

            <!--panel title-->
            <div class="rpanel-title">
                <i class="icon-Filter-2"></i>@lang('lang.filter_refunds')
                <span>
                    <i class="ti-close js-close-side-panels" data-target="sidepanel-filter-refunds"></i>
                </span>
            </div>
            <!--panel title-->

            <!--panel body-->
            <div class="r-panel-body">

                <!--refund date filter-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.refund_date')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <!--start date-->
                            <div class="col-md-6">
                                <input type="text" name="filter_refund_date_start"
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="{{ cleanLang(__('lang.start')) }}"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_refund_date_start') ?? '') }}">
                                <input class="mysql-date" type="hidden"
                                    name="filter_refund_date_start" id="filter_refund_date_start"
                                    value="{{ config('filter.saved_data.filter_refund_date_start') ?? '' }}">
                            </div>
                            <!--end date-->
                            <div class="col-md-6">
                                <input type="text" name="filter_refund_date_end"
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="{{ cleanLang(__('lang.end')) }}"
                                    value="{{ runtimeDatepickerDate(config('filter.saved_data.filter_refund_date_end') ?? '') }}">
                                <input class="mysql-date" type="hidden"
                                    name="filter_refund_date_end" id="filter_refund_date_end"
                                    value="{{ config('filter.saved_data.filter_refund_date_end') ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <!--refund date filter-->

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

                <!--filter buttons-->
                <div class="buttons-block">
                    <button type="button"
                        class="btn btn-rounded-x btn-secondary js-reset-filter-side-panel">{{ cleanLang(__('lang.reset')) }}</button>
                    <input type="hidden" name="action" value="search">
                    <input type="hidden" name="source" value="{{ $page['source_for_filter_panels'] ?? '' }}">
                    <button type="button"
                        class="btn btn-rounded-x btn-danger js-ajax-ux-request apply-filter-button"
                        data-url="{{ urlResource('/refunds/search') }}"
                        data-type="form"
                        data-ajax-type="GET">{{ cleanLang(__('lang.apply_filter')) }}</button>
                </div>
                <!--filter buttons-->

            </div>
            <!--panel body-->

        </div>
    </form>
</div>
<!--filter side panel-->
