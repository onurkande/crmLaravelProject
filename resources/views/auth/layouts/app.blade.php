<!doctype html>
<html class="no-js " lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

    <title>@yield('title')</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/authentication.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
    @php
        $settings = \App\Models\SiteSetting::first();
    @endphp
    @if ($settings && $settings->favicon)
        <link rel="icon" href="{{ asset('storage/' . $settings->favicon) }}">
    @else
        <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}">
    @endif
</head>

<body class="theme-purple authentication sidebar-collapse">
<!-- Navbar -->
@php
    $settings = \App\Models\SiteSetting::first();
@endphp
<nav class="navbar navbar-expand-lg fixed-top navbar-transparent">
    <div class="container">        
        <div class="navbar-translate n_logo">
            @if($settings && $settings->app_name)
                <a class="navbar-brand" href="/" title="" target="_blank"><h4 class="text-light mt-0">{{ $settings->app_name }}</h4></a>
            @endif
            <button class="navbar-toggler" type="button">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </button>
        </div>
        <div class="navbar-collapse">
            <ul class="navbar-nav">               
                <li class="nav-item">
                    @yield('navbar')
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->

<div class="page-header">
    <div class="page-header-image" style="background-image:url({{ asset('assets/images/login.jpg') }})"></div>

    @yield('content')

    <footer class="footer">
        <div class="container">
            
            <div class="copyright">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script>,
                <span>Designed by <a href="/" target="_blank">noyanlar</a></span>
            </div>
        </div>
    </footer>
</div>

<!-- Jquery Core Js -->
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js -->

<script>
   $(".navbar-toggler").on('click',function() {
    $("html").toggleClass("nav-open");
});
//=============================================================================
$('.form-control').on("focus", function() {
    $(this).parent('.input-group').addClass("input-group-focus");
}).on("blur", function() {
    $(this).parent(".input-group").removeClass("input-group-focus");
});
</script>
</body>
</html>