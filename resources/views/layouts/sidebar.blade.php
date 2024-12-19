<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="{{ url('/home') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
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
                                <a class="nav-link collapsed" href="@if(Route::has($item['url_menu'])) {{ route($item['url_menu']) }} @endif">
                                <i class="{{ $item['icon_menu'] }}"></i>
                                <span>{{ $item['nama_menu'] ?? '' }}</span>
                                </a>
                            </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link collapsed" data-bs-target="#{{ Str::slug($item['nama_menu'] ?? '', '-') }}-nav" data-bs-toggle="collapse" href="#">
                                <i class="bi bi-menu-button-wide"></i><span>{{ $item['nama_menu'] ?? '' }}</span><i class="bi bi-chevron-down ms-auto"></i>
                            </a>
                            <ul id="{{ Str::slug($item['nama_menu'] ?? '', '-') }}-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                                @foreach($item['submenu'] as $submenu)
                                @php $url = $submenu['url_menu']; @endphp
                                    <li>
                                        <a href="@if(Route::has($submenu['url_menu'])) {{ route($submenu['url_menu']) }} @endif"><i class="bi bi-circle"></i><span>{{ $submenu['nama_menu'] }}</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            @endisset
            <form action="{{ route('logout') }}" method="post" id="logout">
                @csrf
            </form>
            <li class="nav-item">
                <a class="nav-link collapsed" onclick="return document.getElementById('logout').submit()">
                <i class="bi bi-file-earmark"></i>
                <span>Logout</span>
                </a>
            </li><!-- End Blank Page Nav -->

    </ul>

  </aside>