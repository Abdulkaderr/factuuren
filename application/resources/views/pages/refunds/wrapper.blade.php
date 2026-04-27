@extends('layout.wrapper')
@section('content')
<!--main content-->
<div class="container-fluid">

    <!--page heading-->
    <div class="row page-titles">

        <!--breadcrumbs-->
        @include('misc.heading-crumbs')
        <!--breadcrumbs-->

        <!--page action buttons-->
        @include('pages.refunds.components.misc.list-page-actions')
        <!--page action buttons-->

    </div>
    <!--page heading-->

    <!--page content-->
    <div class="row">
        <div class="col-12">
            <!--refunds table-->
            @include('pages.refunds.components.table.wrapper')
            <!--refunds table-->
        </div>
    </div>
    <!--page content-->

    <!--filter side panel-->
    @include('pages.refunds.components.misc.filter-refunds')
    <!--filter side panel-->

</div>
<!--main content-->
@endsection
