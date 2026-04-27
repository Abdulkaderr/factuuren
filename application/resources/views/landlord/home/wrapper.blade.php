@extends('landlord.layout.wrapper') @section('content')
<!-- main content -->
<div class="container-fluid saas-home p-l-30 p-r-30">

    @if(config('visibility.home_payments_panel'))
    <!-- top panel stats -->
    @include('landlord.home.components.panel-top-stats')

    <!-- income chart -->
    @include('landlord.home.components.panel-income-chart')
    @endif

    <!-- new customers chart (available to all) -->
    @include('landlord.home.components.panel-customers-chart')

    <!-- events timeline -->
    @if(config('visibility.home_events_panel'))
    @include('landlord.home.components.panel-events')
    @endif


</div>
<!--main content -->
@endsection