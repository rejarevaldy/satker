<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}"
    style="margin-top:0px;     min-height: 100% !important;">
    {{-- Sidebar brand logo --}}
    @if (config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar" style="height:100%;
    overflow:auto;">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if (config('adminlte.sidebar_nav_animation_speed') != 300) data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}" @endif
                @if (!config('adminlte.sidebar_nav_accordion')) data-accordion="false" @endif>
                {{-- Configured sidebar links --}}
                @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')

                @if (Auth()->user()->role == 'Satker')
                    <li class="nav-item">
                        {{-- <a class="nav-link" href="{{ route('laporan.list', Auth()->user()->username) }}"> --}}
                        <a class="nav-link" href="/laporan/{{ auth()->user()->username }}">
                            <i class="fa fa-th "></i>
                            <p>
                                Laporan
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dokumen') }}">
                            <i class="fa fa-th "></i>
                            <p>
                                Dokumen
                            </p>
                        </a>
                    </li>
                @endif

                @if (Auth()->user()->role == 'Monitoring')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('laporan') }}">
                            <i class="fa fa-th "></i>
                            <p>
                                Laporan
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('list') }}">
                            <i class="fa fa-th "></i>
                            <p>
                                Rekap
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.list') }}">
                            <i class="fa fa-users "></i>
                            <p>
                                Pengguna
                            </p>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profil') }}">
                        <i class="fa fa-user "></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li>



                <li class="nav-item">
                    <form action="/logout/" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger nav-link text-white" href="/logout/">
                            <i class="fas fa-fw fa-sign-out-alt "></i>
                            Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>

</aside>
