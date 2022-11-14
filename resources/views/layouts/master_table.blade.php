<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    
    <title>@yield('title') - Sistem Pengajuan Proposal dan Kegiatan Mahasiswa UBP Karawang</title>
    <link rel="apple-touch-icon" href="{{ asset('vuexy') }}/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('vuexy') }}/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/hasil_combine.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
    <script type="text/javascript">
        var user_theme = "{{ session('user_theme') }}";
        
    </script>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
    @include('sweetalert::alert')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
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
