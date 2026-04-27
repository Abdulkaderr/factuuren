<!--bulk actions-->
@include('pages.refunds.components.actions.checkbox-actions')

<!--main table view-->
@include('pages.refunds.components.table.table')

<!--filter-->
@if(auth()->user()->is_team)
@include('pages.refunds.components.misc.filter-refunds')
@endif
<!--filter-->
