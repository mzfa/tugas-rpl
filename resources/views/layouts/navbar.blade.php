<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ url('/home') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ url('/home') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                {{-- <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="17"> --}}
                <h2 class="text-white mt-3">SCM</h2>
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div class="dropdown sidebar-user m-1 rounded">
        <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center gap-2">
                <img class="rounded header-profile-user" src="{{ asset('assets/images/users/avatar-1.jpg" alt="') }}Header Avatar">
                <span class="text-start">
                    <span class="d-block fw-medium sidebar-user-name-text">Anna Adame</span>
                    <span class="d-block fs-14 sidebar-user-name-sub-text"><i class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span class="align-middle">Online</span></span>
                </span>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <h6 class="dropdown-header">Welcome Anna!</h6>
            <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
            <a class="dropdown-item" href="apps-chat.html"><i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Messages</span></a>
            <a class="dropdown-item" href="apps-tasks-kanban.html"><i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Taskboard</span></a>
            <a class="dropdown-item" href="pages-faqs.html"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Help</span></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance : <b>$5971.67</b></span></a>
            <a class="dropdown-item" href="pages-profile-settings.html"><span class="badge bg-success-subtle text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Settings</span></a>
            <a class="dropdown-item" href="auth-lockscreen-basic.html"><i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock screen</span></a>
            <a class="dropdown-item" href="auth-logout-basic.html"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
        </div>
    </div>
    <div id="scrollbar">
        <div class="container-fluid">


            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('home') }}">
                        <i class="ri-honour-line"></i> <span data-key="t-home">Home</span>
                    </a>
                </li>

                @php
                    $sidebar = Session('menu');
                    // dd($sidebar);
                @endphp
                @isset($sidebar)
                    @foreach($sidebar as $item)
                        @if(empty($item['submenu'][0]))
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="@if(Route::has($item['url_menu'])) {{ route($item['url_menu']) }} @endif">
                                    <i class="ri-layout-3-line"></i> <span data-key="t-home">{{ $item['nama_menu'] ?? '' }}</span>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#{{ Str::slug($item['nama_menu'] ?? '', '-') }}" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="{{ Str::slug($item['nama_menu'] ?? '', '-') }}">
                                    <i class="ri-layout-3-line"></i> <span data-key="t-layouts">{{ $item['nama_menu'] ?? '', '-' }}</span> 
                                    {{-- <span class="badge badge-pill bg-danger" data-key="t-hot">Hot</span> --}}
                                </a>
                                <div class="collapse menu-dropdown" id="{{ Str::slug($item['nama_menu'] ?? '', '-') }}">
                                    <ul class="nav nav-sm flex-column">
                                        @foreach($item['submenu'] as $submenu)
                                        @php $url = $submenu['url_menu']; @endphp
                                            <li class="nav-item">
                                                <a href="@if(Route::has($submenu['url_menu'])) {{ route($submenu['url_menu']) }} @endif" class="nav-link" data-key="t-horizontal">{{ $submenu['nama_menu'] }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endisset

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('logout') }}">
                        <i class="mdi mdi-logout fs-16 align-middle me-1"></i> <span data-key="t-home">Logout</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>