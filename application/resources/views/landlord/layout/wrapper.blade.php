<!DOCTYPE html>
<html lang="en" class="app-admin">

<!--html header-->
@include('landlord.layout.header')
<!--html header-->

<body id="main-body" data-main-menu-id="{{ $page['main_menu_id'] ?? '' }}"
    data-sub-menu-id="{{ $page['sub_menu_id'] ?? '' }}"
    class="loggedin fix-header card-no-border fix-sidebar {{ runtimePreferenceLeftmenuPosition(auth()->user()->left_menu_position) }} {{ $page['page'] ?? '' }}">

    <!--inject any contect here-->
    {!! config('inject.body_start') !!}

    <!--module extension point-->
    @stack('landlord_layout_wrapper_1')

    <!--main wrapper-->
    <div id="main-wrapper">

        <!--module extension point-->
        @stack('landlord_layout_wrapper_2')

        <!---------------------------------------------------------------------------------------
            [NEXTLOOP}
             always collapse left menu for small devices
            (NB: this code is in the correct place. It must run before menu is added to DOM)
         --------------------------------------------------------------------------------------->

        <!--top nav-->
        @include('landlord.layout.topnav') @include('landlord.layout.leftmenu')
        <!--top nav-->


        <!--page wrapper-->
        <div class="page-wrapper {{ runtimeLeftInnerMenu(config('visibility.left_inner_menu')) }}">

            <!--module extension point-->
            @stack('landlord_layout_wrapper_3')

            <!--left menu-->
            @if(config('visibility.left_inner_menu') != '')
            <div class="left-inner-menu" id="landlord-left-inner-menu">
                <!--settings menu-->
                @if(config('visibility.left_inner_menu') == 'settings')
                @include('landlord.settings.leftmenu')
                @endif
                <!--frontend menu-->
                @if(config('visibility.left_inner_menu') == 'frontend')
                @include('landlord.frontend.leftmenu')
                @endif
            </div>
            @endif


            <!--overlay-->
            <div class="page-wrapper-overlay js-close-side-panels hidden" data-target=""></div>
            <!--overlay-->

            <!--preloader-->
            <div class="preloader">
                <div class="loader">
                    <div class="loader-loading"></div>
                </div>
            </div>
            <!--preloader-->


            <!-- main content -->
            @yield('content')
            <!-- /#main content -->

        </div>
        <!--page wrapper-->
    </div>

    <!--module extension point-->
    @stack('landlord_layout_wrapper_4')

    <!--common modals-->
    @include('modals.common-modal-wrapper')
    @include('modals.actions-modal-wrapper')

    <!--module extension point-->
    @stack('landlord_layout_wrapper_5')

    <!--js footer-->
    @include('landlord.layout.footerjs')

    <!--inject any contect here-->
    {!! config('inject.body_end') !!}
</body>

<!--module extension point-->
@stack('landlord_layout_wrapper_6')

</html>