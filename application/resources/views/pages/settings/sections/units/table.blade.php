<div class="table-responsive p-b-30" id="units-table-wrapper">
    @if (@count($units ?? []) > 0)
    <table id="units-list" class="table m-t-0 m-b-0 table-hover no-wrap units-list">
        <thead>
            <tr>
                <th class="units_col_name">{{ cleanLang(__('lang.unit_name')) }}</th>
                <th class="units_col_created_by">{{ cleanLang(__('lang.created_by')) }}</th>
                <th class="units_col_products">{{ cleanLang(__('lang.products')) }}</th>
                <th class="units_col_action w-px-110"><a href="javascript:void(0)">{{ cleanLang(__('lang.action')) }}</a></th>
            </tr>
        </thead>
        <tbody id="units-td-container">
            <!--ajax content here-->
            @include('pages.settings.sections.units.ajax')
            <!--ajax content here-->
        </tbody>
    </table>
    @endif
    @if (@count($units ?? []) == 0)
    <!--nothing found-->
    @include('notifications.no-results-found')
    <!--nothing found-->
    @endif
</div>
