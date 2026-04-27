<div class="embedded-bill clearfix">
    <!--INVOICE TABLE-->
@include('pages.bill.components.elements.main-table')

<!-- TOTAL & SUMMARY -->
@if($bill->bill_tax_type == 'inline')
@include('pages.bill.components.elements.totals-inline')
@else
@include('pages.bill.components.elements.totals-summary')
@endif
</div>