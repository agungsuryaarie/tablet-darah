<li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
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
                    <p>Users Puskesmas</p>
                </a>
            </li>
        </ul>
    </li>
@elseif (Auth::user()->role == 2)
    <li
        class="nav-item {{ request()->segment(1) == 'users-sekolah' || request()->segment(1) == 'users-sekolah' || request()->segment(1) == 'sekolah-binaan' || request()->segment(1) == 'posyandu-binaan' ? 'menu-open' : '' }}">
        <a href="#"
            class="nav-link {{ request()->segment(1) == 'users-posyandu' || request()->segment(1) == 'users-posyandu' || request()->segment(1) == 'sekolah-binaan' || request()->segment(1) == 'posyandu-binaan' ? 'active' : '' }}">
            <i class="nav-icon fas fa-database"></i>
            <p>
                Master data
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('sekolah-binaan.index') }}"
                    class="nav-link {{ request()->segment(1) == 'sekolah-binaan' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sekolah Binaan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('posyandu-binaan.index') }}"
                    class="nav-link {{ request()->segment(1) == 'posyandu-binaan' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Posyandu Binaan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('usersekolah.index') }}"
                    class="nav-link {{ request()->segment(1) == 'users-sekolah' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Users Sekolah</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('userposyandu.index') }}"
                    class="nav-link {{ request()->segment(1) == 'users-posyandu' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Users Posyandu</p>
                </a>
            </li>
        </ul>
    </li>
@elseif (Auth::user()->role == 3)
    <li
        class="nav-item {{ request()->segment(1) == 'jurusan' || request()->segment(1) == 'kelas' ? 'menu-open' : '' }}">
        <a href="#"
            class="nav-link {{ request()->segment(1) == 'jurusan' || request()->segment(1) == 'kelas' ? 'active' : '' }}">
            <i class="nav-icon fas fa-database"></i>
            <p>
                Master data
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('jurusan.index') }}"
                    class="nav-link {{ request()->segment(1) == 'jurusan' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Jurusan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kelas.index') }}"
                    class="nav-link {{ request()->segment(1) == 'kelas' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kelas</p>
                </a>
            </li>
        </ul>
    </li>
    <li
        class="nav-item {{ request()->segment(2) == 'create' || request()->segment(1) == 'rematri' ? 'menu-open' : '' }}">
        <a href="#"
            class="nav-link {{ request()->segment(2) == 'create' || request()->segment(1) == 'rematri' ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>
                Entry Rematri
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('rematri.create') }}"
                    class="nav-link {{ request()->segment(1) == 'create' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tambah Rematri</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('rematri.index') }}"
                    class="nav-link {{ request()->segment(1) == 'rematri' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Rematri</p>
                </a>
            </li>
        </ul>
    </li>
@elseif (Auth::user()->role == 4)
    <li
        class="nav-item {{ request()->segment(2) == 'create' || request()->segment(1) == 'rematri-posyandu' ? 'menu-open' : '' }}">
        <a href="#"
            class="nav-link {{ request()->segment(2) == 'create' || request()->segment(1) == 'rematri-posyandu' ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>
                Entry Rematri
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('rematrip.create') }}"
                    class="nav-link {{ request()->segment(2) == 'create' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tambah Rematri</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('rematrip.index') }}"
                    class="nav-link {{ request()->segment(1) == 'rematri-posyandu' ? 'active' : '' }}">
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
