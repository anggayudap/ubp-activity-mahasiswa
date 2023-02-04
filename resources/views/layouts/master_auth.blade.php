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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    @stack('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/hasil_combine.css') }}">
    <link href="{{ asset('css/auth_styles.css') }}" rel="stylesheet">

    <script type="text/javascript">
        let current_url = "{{ url()->current() }}";
    </script>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->


<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="blank-page" data-framework="laravel"
    data-asset-path="{{ URL::asset('vuexy') . '/' }}">
    @include('sweetalert::alert')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- END: Content-->


    <script src="{{ URL::asset('js/hasil_combine.js') }}"></script>
    <script src="{{ URL::asset('js/form.js') }}"></script>

    @stack('scripts')
    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>

</body>
<!-- END: Body-->

</html>
