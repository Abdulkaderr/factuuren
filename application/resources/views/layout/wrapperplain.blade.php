<!DOCTYPE html>
<html lang="en" class="logged-out {{ config('visibility.page_rendering') }} {{ config('active_theme') }}"
    data-bs-theme="{{ config('active_theme') }}">

<!--html header-->
@include('layout.header')
<!--html header-->

<body class="{{ $page['page'] ?? '' }}">

    <!--inject any contect here-->
    {!! config('inject.body_start') !!}

    <!--module extension point-->
    @stack('layout_wrapper_plain_1')

    <!--preloader-->
    @if(config('visibility.page_rendering') == '' || config('visibility.page_rendering') != 'print-page')
    <div class="preloader">
        <div class="loader">
            <div class="loader-loading"></div>
        </div>
    </div>
    @endif
    <!--preloader-->

    <!--main content-->
    <div id="main-wrapper">

        <!--module extension point-->
        @stack('layout_wrapper_plain_2')

        @yield('content')

        <!--module extension point-->
        @stack('layout_wrapper_plain_3')
    </div>

    <!--module extension point-->
    @stack('layout_wrapper_plain_4')

    <!--common modals-->
    @include('modals.actions-modal-wrapper')
    @include('modals.common-modal-wrapper')

    <!--inject any contect here-->
    {!! config('inject.body_end') !!}
</body>

<!--module extension point-->
@stack('layout_wrapper_plain_5')

@include('layout.footerjs')
<!--js automations-->
@include('layout.automationjs')
<!--[note: no sanitizing required] for this trusted content, which is added by the admin-->
{!! config('system.settings_theme_body') !!}

<!--[PRINTING]-->
@if(config('visibility.page_rendering') == 'print-page')
<script src="public/js/dynamic/print.js?v={{ config('system.versioning') }}"></script>
@endif

<!--module extension point-->
@stack('layout_wrapper_plain_6')

</html>