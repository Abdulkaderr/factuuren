<!DOCTYPE html>
<html lang="en"
    class="{{ auth()->user()->type ?? '' }} {{ config('visibility.page_rendering') }} {{ config('active_theme') }} @stack('css_wrapper_html')"
    data-bs-theme="{{ config('active_theme') }}">

<!--CRM - GROWCRM.IO-->
@include('layout.header')

<body id="main-body" data-main-menu-id="{{ $page['main_menu_id'] ?? '' }}"
    data-sub-menu-id="{{ $page['sub_menu_id'] ?? '' }}"
    class="loggedin fix-header card-no-border fix-sidebar {{ config('settings.css_kanban') }} {{ runtimePreferenceLeftmenuPosition(auth()->user()->left_menu_position) }} {{ $page['page'] ?? '' }} {{ runtimeDistractionFreeBodyClass() }} @stack('css_wrapper_body')">

    <!--inject any contect here-->
    {!! config('inject.body_start') !!}

    <!--module extension point-->
    @stack('layout_wrapper_1')

    <!--main wrapper-->
    <div id="main-wrapper">

        <!--module extension point-->
        @stack('layout_wrapper_2')

        <!---------------------------------------------------------------------------------------
            [NEXTLOOP}
             always collapse left menu for small devices
            (NB: this code is in the correct place. It must run before menu is added to DOM)
         --------------------------------------------------------------------------------------->

        <!--top nav-->
        @include('nav.topnav') @include('nav.leftmenu')
        <!--top nav-->

        <!--module extension point-->
        @stack('layout_wrapper_3')

        <!--page wrapper-->
        <div class="page-wrapper">

            <!--module extension point-->
            @stack('layout_wrapper_4')

            <!--overlay-->
            <div class="page-wrapper-overlay js-close-side-panels hidden" data-target=""></div>
            <!--overlay-->

            <!--preloader-->
            @if(config('visibility.page_rendering') == '' || config('visibility.page_rendering') != 'print-page')
            <div class="preloader">
                <div class="loader">
                    <div class="loader-loading"></div>
                </div>
            </div>
            @endif
            <!--preloader-->


            <!-- main content -->
            @yield('content')
            <!-- /#main content -->


            <!--reminders panel-->
            @include('pages.reminders.misc.reminder-panel')

            <!--notifications panel-->
            @include('nav.notifications-panel')

            <!--panels-->
            @include('nav.reminders-panel')

            <!--module extension point-->
            @stack('layout_wrapper_4')

        </div>

        <!--module extension point-->
        @stack('layout_wrapper_5')

        @include('pages.starred.panel')

        <!--page wrapper-->
    </div>

    <!--module extension point-->
    @stack('layout_wrapper_6')

    <!--common modals-->
    @include('modals.actions-modal-wrapper')
    @include('modals.common-modal-wrapper')
    @include('modals.plain-modal-wrapper')
    @include('pages.search.modal.search')
    @include('pages.authentication.modal.relogin')

    <!--selector - modals-->
    @include('modals.create')


    <!--js footer-->
    @include('layout.footerjs')

    <!--js automations-->
    @include('layout.automationjs')

    <!--[note: no sanitizing required] for this trusted content, which is added by the admin-->
    {!! config('system.settings_theme_body') !!}

    <!--module extension point-->
    @stack('layout_wrapper_7')

    <!--inject any contect here-->
    {!! config('inject.body_end') !!}
</body>

<!--module extension point-->
@stack('layout_wrapper_8')

<!--[PRINTING]-->
@if(config('visibility.page_rendering') == 'print-page')
<script src="public/js/dynamic/print.js?v={{ config('system.versioning') }}"></script>
@endif

<!--module extension point-->
@stack('layout_wrapper_9')

</html>