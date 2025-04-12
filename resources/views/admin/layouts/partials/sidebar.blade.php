<aside id="leftsidebar" class="sidebar">
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <div class="image"><a href="{{route('admin.profile.index')}}"><img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('assets/images/default-avatar.png') }}" alt="User"></a></div>
                    <div class="detail mb-2">
                        <h4>{{ Auth::user()->name }}</h4>
                        <small>{{ Auth::user()->user_type == 'admin' ? 'admin' : (Auth::user()->user_type == 'sales_consultant' ? 'satış danışmanı' : (Auth::user()->user_type == 'agency' ? 'acenta' : Auth::user()->user_type)) }}</small>                        
                    </div>
                    <!--<a href="events.html" title="Events"><i class="zmdi zmdi-calendar"></i></a>
                    <a href="mail-inbox.html" title="Inbox"><i class="zmdi zmdi-email"></i></a>
                    <a href="contact.html" title="Contact List"><i class="zmdi zmdi-account-box-phone"></i></a>
                    <a href="chat.html" title="Chat App"><i class="zmdi zmdi-comments"></i></a>
                    <a href="sign-in.html" title="Sign out"><i class="zmdi zmdi-power"></i></a>-->
                </div>
            </li>

            <li class="header">Sayfalar</li>

            @if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'sales_consultant')
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active open' : '' }}"><a href="{{ route('admin.dashboard') }}"><i class="zmdi zmdi-home"></i><span>Ana Sayfa</span></a></li>
            @endif

            <li class="{{ request()->routeIs('admin.advertisements.*') ? 'active open' : '' }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-collection-text"></i><span>İlanlar</span> </a>
                <ul class="ml-menu">
                    <li><a href="{{ route('admin.advertisements.index') }}">İlanlar</a></li>
                    @if(Auth::user()->user_type == 'admin')
                    <li><a href="{{ route('admin.advertisements.create') }}">İlan Ekle</a></li>
                    @endif
                </ul>
            </li>

            <!-- Yeni eklenen notlar menüsü -->
            @if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'sales_consultant')
            <li class="{{ request()->routeIs('admin.notes.*') ? 'active open' : '' }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-assignment"></i><span>Notlar</span> </a>
                <ul class="ml-menu">
                    <li><a href="{{ route('admin.notes.index') }}">Notlar</a></li>
                    <li><a href="{{ route('admin.notes.create') }}">Not Ekle</a></li>
                </ul>
            </li>
            @endif
            <!-- Kullanıcılar menüsü -->
            @if(Auth::user()->user_type == 'admin')
            <li class="{{ request()->routeIs('admin.users.*') ? 'active open' : '' }}"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-accounts"></i><span>Kullanıcılar</span> </a>
                <ul class="ml-menu">
                    <li><a href="{{ route('admin.users.index') }}">Kullanıcılar</a></li>
                    <li><a href="{{ route('admin.users.create') }}">Kullanıcı Ekle</a></li>
                </ul>
            </li>
            @endif
            <!-- Komisyon Hesaplama menüsü -->
            @if(Auth::user()->user_type == 'admin')
            <li class="{{ request()->routeIs('admin.commissions.*') ? 'active open' : '' }}">
                <a href="{{ route('admin.commissions.index') }}">
                    <i class="zmdi zmdi-money"></i><span>Komisyon Hesaplama</span>
                </a>
            </li>
            @endif
            <!-- Site Ayarları menüsü -->
            @if(Auth::user()->user_type == 'admin')
            <li class="{{ request()->routeIs('admin.settings.*') ? 'active open' : '' }}">
                <a href="{{ route('admin.settings.index') }}">
                    <i class="zmdi zmdi-settings"></i><span>Site Ayarları</span>
                </a>
            </li>
            @endif

            <li class="{{ request()->routeIs('admin.profile.*') ? 'active open' : '' }}">
                <a href="{{ route('admin.profile.index') }}">
                    <i class="zmdi zmdi-account"></i><span>Profil</span>
                </a>
            </li>
        </ul>
    </div>
</aside>