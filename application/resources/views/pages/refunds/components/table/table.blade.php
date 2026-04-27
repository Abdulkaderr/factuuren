<div class="card count-{{ @count($refunds ?? []) }}" id="refunds-table-wrapper">
    <div class="card-body">
        <!--filtered results warning-->
        @if(config('filter.status') == 'active')
        <div class="filtered-results-warning opacity-8 p-b-5">
            <small>
                @lang('lang.these_results_are')
                <a href="javascript:void(0);" class="js-toggle-side-panel" data-target="sidepanel-filter-refunds">@lang('lang.filtered')</a>.
                @lang('lang.you_can')
                <a href="{{ url('/refunds?clear-filter=yes') }}">@lang('lang.clear_the_filters')</a>.
            </small>
        </div>
        @endif
        <div class="table-responsive list-table-wrapper">

            @if (@count($refunds ?? []) > 0)
            <table class="table m-t-0 m-b-0 table-hover no-wrap contact-list" id="refunds-list-table"
                data-page-size="10">
                <thead>
                    <tr>
                        <!--checkbox column-->
                        @if(config('visibility.refunds_col_checkboxes'))
                        <th class="list-checkbox-wrapper refunds_col_checkbox">
                            <span class="list-checkboxes display-inline-block w-px-20">
                                <input type="checkbox" id="listcheckbox-refunds" name="listcheckbox-refunds"
                                    class="listcheckbox-all filled-in chk-col-light-blue"
                                    data-actions-container-class="refunds-checkbox-actions-container"
                                    data-children-checkbox-class="listcheckbox-refunds">
                                <label for="listcheckbox-refunds"></label>
                            </span>
                        </th>
                        @endif

                        <!--id column-->
                        <th class="refunds_col_id"><a class="js-ajax-ux-request js-list-sorting" id="sort_refund_id"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/refunds?action=sort&orderby=refund_id&sortorder=asc') }}">{{ cleanLang(__('lang.id')) }}#<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>

                        <!--date column-->
                        <th class="refunds_col_date"><a class="js-ajax-ux-request js-list-sorting" id="sort_refund_date"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/refunds?action=sort&orderby=refund_date&sortorder=asc') }}">{{ cleanLang(__('lang.date')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>

                        <!--payment column-->
                        <th class="refunds_col_payment"><a class="js-ajax-ux-request js-list-sorting" id="sort_refund_paymentid"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/refunds?action=sort&orderby=refund_paymentid&sortorder=asc') }}">{{ cleanLang(__('lang.payment')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>

                        <!--amount column-->
                        <th class="refunds_col_amount"><a class="js-ajax-ux-request js-list-sorting" id="sort_refund_amount"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/refunds?action=sort&orderby=refund_amount&sortorder=asc') }}">{{ cleanLang(__('lang.amount')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>

                        <!--client column-->
                        <th class="refunds_col_client"><a class="js-ajax-ux-request js-list-sorting" id="sort_client"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/refunds?action=sort&orderby=client&sortorder=asc') }}">{{ cleanLang(__('lang.client')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>

                        <!--issued by column-->
                        <th class="refunds_col_creator"><a class="js-ajax-ux-request js-list-sorting" id="sort_first_name"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/refunds?action=sort&orderby=first_name&sortorder=asc') }}">{{ cleanLang(__('lang.issued_by')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>

                        <!--tags column-->
                        @if(config('visibility.refunds_col_tags'))
                        <th class="refunds_col_tags"><a href="javascript:void(0)">{{ cleanLang(__('lang.tags')) }}</a></th>
                        @endif

                        <!--action column (no sorting icon)-->
                        @if(config('visibility.refunds_col_action'))
                        <th class="refunds_col_action actions_column">
                            <a href="javascript:void(0)">@lang('lang.action')</a>
                        </th>
                        @endif
                    </tr>
                </thead>
                <tbody id="refunds-td-container">
                    <!--ajax rows-->
                    @include('pages.refunds.components.table.ajax')
                    <!--ajax rows-->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="20">
                            <!--load more button-->
                            @include('misc.load-more-button')
                            <!--load more button-->
                        </td>
                    </tr>
                </tfoot>
            </table>
            @endif

            @if (@count($refunds ?? []) == 0)
            <!--nothing found-->
            @include('notifications.no-results-found')
            <!--nothing found-->
            @endif

        </div>
    </div>
</div>
