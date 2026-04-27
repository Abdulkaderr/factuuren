<!DOCTYPE html>
<html lang="en" class="app-admin logged-out">

<!--html header-->
@include('landlord.layout.header')
<!--html header-->

<body class="{{ $page['page'] ?? '' }}">

    <!--inject any contect here-->
    {!! config('inject.body_start') !!}

    <!--module extension point-->
    @stack('landlord_layout_wrapper_plain_1')

    <!--preloader-->
    <div class="preloader">
        <div class="loader">
            <div class="loader-loading"></div>
        </div>
    </div>
    <!--preloader-->

    <!--main content-->
    <div id="main-wrapper">

        <!--module extension point-->
        @stack('landlord_layout_wrapper_plain_2')

        @yield('content')
    </div>

    <!--inject any contect here-->
    {!! config('inject.body_end') !!}
</body>

<!--module extension point-->
@stack('landlord_layout_wrapper_plain_3')

@include('landlord.layout.footerjs')

<!--module extension point-->
@stack('landlord_layout_wrapper_plain_4')

</html>