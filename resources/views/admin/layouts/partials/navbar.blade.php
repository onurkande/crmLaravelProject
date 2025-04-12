@php
    $settings = \App\Models\SiteSetting::first();
@endphp

<nav class="navbar">
    <div class="col-12">        
        <div class="navbar-header">
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="index.html">
                @if ($settings && $settings->logo)
                    <img src="{{ asset('storage/' . $settings->logo) }}" width="30"><span class="m-l-10">{{ $settings->app_name }}</span>
                @else
                    <img src="{{ asset('assets/images/logo.svg') }}" width="30"><span class="m-l-10">Admin Paneli</span>
                @endif
            </a>
        </div>
        <ul class="nav navbar-nav navbar-left">
            <li><a href="javascript:void(0);" class="ls-toggle-btn" data-close="true"><i class="zmdi zmdi-swap"></i></a></li>            
            <li class="hidden-sm-down">
                <!--<div class="input-group">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-addon">
                        <i class="zmdi zmdi-search"></i>
                    </span>
                </div>-->
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li>
                <div class="gtranslate_wrapper">
                    <style>
                        .gtranslate_wrapper a {
                            color: #333 !important;
                        }
                    </style>
                </div>
            </li>
            <li>
                <a href="javascript:void(0);" class="fullscreen hidden-sm-down" data-provide="fullscreen" data-close="true"><i class="zmdi zmdi-fullscreen"></i></a>
            </li>
            <li>
                <a href="{{ route('logout') }}" class="mega-menu" data-close="true" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="zmdi zmdi-power"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
            <!--<li class=""><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="zmdi zmdi-settings zmdi-hc-spin"></i></a></li>-->
        </ul>
    </div>
</nav>