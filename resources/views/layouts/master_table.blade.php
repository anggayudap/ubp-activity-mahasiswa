<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="author" content="anggayudap">
    <title>@yield('title') - SIMKATMAWA UBP Karawang</title>

    <link rel="icon" type="image/png" href="{{ asset('logo-kecil.png') }}">
    <link href="{{ URL::asset('css/font_default.css') }}" rel="stylesheet">

    @stack('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/hasil_combine.css') }}">

    <script type="text/javascript">
        let user_theme = "{{ session('user_theme') }}";   
    </script>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page" data-framework="laravel" data-asset-path="{{ URL::asset('vuexy').'/' }}">
    @include('sweetalert::alert')

    <!-- BEGIN: Content-->
    {{-- <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">@yield('title')</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                @yield('content')

            </div>
        </div>
    </div> --}}
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
           
            
                @yield('content')

        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix mb-0">
        <span class="float-md-left d-block d-md-inline-block mt-25">Universitas Buana Perjuangan Karawang &copy; {{ date('Y') }}</span>
        <span class="float-md-right d-none d-md-block">Hand-crafted & Made with<i data-feather="heart"></i></span>
        </p>
    </footer>
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
    <!-- END: Footer-->


    <script src="{{ URL::asset('js/hasil_combine.js') }}"></script>

    <script>
        $(window).on('load', function () {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })

    </script>

    @stack('scripts')
</body>
<!-- END: Body-->

</html>
