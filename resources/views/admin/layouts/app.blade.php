<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('admin.layouts.head')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.layouts.navbar')
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('dashboard') }}" class="brand-link">
                <img src="{{ url('dist/img/logo-ttd.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Administrator</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-1 d-flex">
                    <div class="image mt-2">
                        @if (Auth::user()->foto == null)
                            <img src="{{ url('storage/foto-user/blank.png') }}" class="img-circle elevation-2"
                                alt="User Image">
                        @else
                            <img src="{{ url('storage/foto-user/' . Auth::user()->foto) }}"
                                class="img-circle elevation-2" alt="User Image">
                        @endif
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->nama }}</a>
                        <small class="text-muted">
                            @if (Auth::user()->role == 1)
                                administrator
                            @elseif(Auth::user()->role == 2)
                                admin puskesmas
                            @elseif(Auth::user()->role == 3)
                                admin sekolah
                            @elseif(Auth::user()->role == 4)
                                admin posyandu
                            @endif
                        </small>
                    </div>
                </div>
                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        @include('admin.layouts.menu')
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">
            <div id="alerts"></div>
            @yield('content')
            @yield('modal')
        </div>
        @include('admin.layouts.footer')
    </div>
