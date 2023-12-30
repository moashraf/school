<!DOCTYPE html>
<html lang="ar" dir="rtl">


<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'نظام لام لادارة المدارس والمنشات التعليمية')</title>
    <meta name="description" content="@yield('description', 'نظام لام لادارة المدارس والمنشات التعليمية')">
    <meta name="author" content="نظام لام لادارة المدارس والمنشات التعليمية">
    <meta name="keywords"
        content="@yield('keywords', 'نظام لام,نظام تعليمي شامل,افضل نظام للمدارس السعودية,نظام تعليمي سعودي,')" />
    <meta name='copyright' content='نظام لام لادارة المدارس والمنشات التعليمية'>
    <meta name='robots' content='noindex, nofollow'>
    <meta name='language' content="AR">

    <!-- Head and css files -->
    @include('website.school.layouts.includes.head')

</head>

<body>

    <!-- Page Loader -->
    <div class="loader-page justify-content-center align-items-center">
        <div class="loader-page-cont">
            <div class="lds-ellipsis">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <img width="100px" src="{{ URL::asset('img/website/logo/lam_logo.svg') }}" alt="">

            <p class="text-gray-400 text-xs mt-2 mb-0">نظام لام لادارة المدارس</p>
            {{-- <p class="text-gray-400 text-xxs">Powered by SHM</p> --}}

        </div>
    </div>

    <!-- fixed content -->
    @yield('fixedcontent')


    @yield('full_content')

    <!-- Page Wrapper -->
    <div id="wrapper" class="d-flex">

        <!-- side bar -->
        @unless(isset($no_sidebar))
        @include('website.school.layouts.includes.sidebar')
        @endunless

        {{-- to hide wrapper in specific pages --}}
        @unless(isset($no_wrapper))
        <!-- Content right Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column flex-grow-1">

            <!-- top bar -->
            @include('website.school.layouts.includes.topbar')

            <!-- Begin Page Content -->

            @yield('content')
            <!-- End content Wrapper -->

            <!-- footer -->
            @include('website.school.layouts.includes.footer')

        </div> <!-- End content left Wrapper -->
        @endunless

    </div> <!-- End content Wrapper -->

    <!-- js scripts -->
    @include('website.school.layouts.includes.footer-script')

</body>

<script>
    window.addEventListener('load', function() {
        // Query all input elements and set autocomplete off
        var inputs = document.getElementsByTagName('input');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].setAttribute('autocomplete', 'off');
        }
    });
</script>
</html>
