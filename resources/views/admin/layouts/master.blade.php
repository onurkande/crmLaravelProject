<!doctype html>
<html class="no-js " lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/morrisjs/morris.min.css') }}" />
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}">
    @php
        $settings = \App\Models\SiteSetting::first();
    @endphp
    @if ($settings && $settings->favicon)
        <link rel="icon" href="{{ asset('storage/' . $settings->favicon) }}">
    @else
        <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}">
    @endif
    @yield('styles')
</head>
<body class="theme-blue">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                @if ($settings && $settings->logo)
                    <img class="zmdi-hc-spin" src="{{ asset('storage/' . $settings->logo) }}" width="48" height="48" alt="Compass">
                @else
                    <img class="zmdi-hc-spin" src="{{ asset('assets/images/logo.svg') }}" width="48" height="48" alt="Compass">
                @endif
            </div>
            <p>Lütfen bekleyiniz...</p>
        </div>
    </div>
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>

    <!-- Top Bar -->
    @include('admin.layouts.partials.navbar')

    <!-- Left Sidebar -->
    @include('admin.layouts.partials.sidebar')

    <!-- Right Sidebar -->
    <!--@include('admin.layouts.partials.right-sidebar')-->

    <!-- Main Content -->
    <section class="content home">
        @yield('content')
        
        <!-- Footer -->
        @include('admin.layouts.partials.footer')
    </section>

    <!-- Jquery Core Js --> 
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) --> 
    <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script> <!-- slimscroll, waves Scripts Plugin Js -->

    <script src="{{ asset('assets/bundles/morrisscripts.bundle.js') }}"></script><!-- Morris Plugin Js -->
    <script src="{{ asset('assets/bundles/jvectormap.bundle.js') }}"></script> <!-- JVectorMap Plugin Js -->
    <script src="{{ asset('assets/bundles/knob.bundle.js') }}"></script> <!-- Jquery Knob Plugin Js -->
    <script src="{{ asset('assets/bundles/countTo.bundle.js') }}"></script> <!-- Jquery CountTo Plugin Js -->
    <script src="{{ asset('assets/bundles/sparkline.bundle.js') }}"></script> <!-- Sparkline Plugin Js -->

    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/index.js') }}"></script>
    
    <script>window.gtranslateSettings = {"default_language":"tr","languages":["tr","en","fa","ru"],"wrapper_selector":".gtranslate_wrapper"}</script>
    <script src="https://cdn.gtranslate.net/widgets/latest/float.js" defer></script>
    
    <!-- Custom Scripts section -->
    @yield('scripts')
</body>
</html>