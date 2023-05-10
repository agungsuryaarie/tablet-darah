<li class="nav-item">
    <a href="{{ 'dashboard' }}" class="nav-link {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
@if (Auth::user()->role == 1)
    <li
        class="nav-item {{ request()->segment(1) == 'kabupaten' ||
        request()->segment(1) == 'kecamatan' ||
        request()->segment(1) == 'desa' ||
        request()->segment(1) == 'puskesmas' ||
        request()->segment(1) == 'posyandu' ||
        request()->segment(1) == 'sekolah' ||
        request()->segment(1) == 'users-puskesmas'
            ? 'menu-open'
            : '' }}">
        <a href="#"
            class="nav-link {{ request()->segment(1) == 'kabupaten' ||
            request()->segment(1) == 'kecamatan' ||
            request()->segment(1) == 'desa' ||
            request()->segment(1) == 'puskesmas' ||
            request()->segment(1) == 'posyandu' ||
            request()->segment(1) == 'sekolah' ||
            request()->segment(1) == 'users-puskesmas'
                ? 'active'
                : '' }}">
            <i class="nav-icon fas fa-database"></i>
            <p>
                Master Data
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('kabupaten.index') }}"
                    class="nav-link {{ request()->segment(1) == 'kabupaten' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kabupaten</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kecamatan.index') }}"
                    class="nav-link {{ request()->segment(1) == 'kecamatan' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kecamatan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('desa.index') }}"
                    class="nav-link {{ request()->segment(1) == 'desa' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Desa/Kelurahan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('puskesmas.index') }}"
                    class="nav-link {{ request()->segment(1) == 'puskesmas' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Puskesmas</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('posyandu.index') }}"
                    class="nav-link {{ request()->segment(1) == 'posyandu' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Posyandu</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('sekolah.index') }}"
                    class="nav-link {{ request()->segment(1) == 'sekolah' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sekolah</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('userpuskes.index') }}"
                    class="nav-link {{ request()->segment(1) == 'users-puskesmas' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>User Puskesmas</p>
                </a>
            </li>
        </ul>
    </li>
@else
    <li
        class="nav-item {{ request()->segment(1) == 'tambah-rematri' || request()->segment(1) == 'data-rematri' ? 'menu-open' : '' }}">
        <a href="#"
            class="nav-link {{ request()->segment(1) == 'tambah-rematri' || request()->segment(1) == 'data-rematri' ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>
                Entry Rematri
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->segment(1) == 'kabupaten' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tambah Rematri</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->segment(1) == 'kecamatan' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Rematri</p>
                </a>
            </li>
        </ul>
    </li>
@endif
<div class="user-panel mt-3">
</div>
<li class="nav-item">
    <a href="{{ route('logout') }}" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>
            Logout
        </p>
    </a>
</li>
