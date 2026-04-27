@extends('layout.wrapper') @section('content')
<!-- main content -->
<div class="container-fluid ticket" id="ticket">

    <!--page heading-->
    <div class="row page-titles">

        <!-- Page Title & Bread Crumbs -->
        @include('misc.heading-crumbs')
        @include('pages.ticket.components.misc.actions')

    </div>
    <!--page heading-->


    <!-- page content -->
    <div class="row">
        <div class="col-12" id="tickets-table-wrapper">
            <!--ticket-->
            @include('pages.ticket.components.body')
            <!--ticket-->
        </div>
    </div>
    <!--page content -->
</div>
<!--main content -->
<!--canned-->
@if(auth()->user()->is_team)
@include('pages.ticket.components.misc.canned-side-panel')
@endif

<!--ticket history side panel-->
<div class="right-sidebar sidebar-lg" id="sidepanel-ticket-history">
    <div class="slimscrollright">
        <div class="rpanel-title">
            <i class="ti ti-history"></i>@lang('lang.ticket_history')
            <span>
                <i class="ti-close js-close-side-panels" data-target="sidepanel-ticket-history"></i>
            </span>
        </div>
        <div class="r-panel-body" id="sidepanel-ticket-history-body">
            <!-- populated via ajax -->
        </div>
    </div>
</div>
<!--ticket history side panel-->

@endsection