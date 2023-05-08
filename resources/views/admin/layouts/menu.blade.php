<li class="nav-item menu-open">
    <a href="{{ '/' }}" class="nav-link {{ request()->segment(1) == '/' ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
<li class="nav-item {{ request()->segment(1) == 'rematri' || request()->segment(1) == 'rematri' ? 'menu-open' : '' }}">
    <a href="#"
        class="nav-link {{ request()->segment(1) == 'rematri' || request()->segment(1) == 'rematri' ? 'active' : '' }}">
        <i class="nav-icon fas fa-database"></i>
        <p>
            Master Data
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('kabupaten.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kabupaten</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('kecamatan.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kecamatan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Desa/Kelurahan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>User</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="{{ route('rematri.index') }}" class="nav-link {{ request()->segment(1) == 'rematri' ? 'active' : '' }}">
        <i class="fa fa-users nav-icon"></i>
        <p>Rematri</p>
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-cog"></i>
        <p>
            Setting
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>
            Logout
        </p>
    </a>
</li>
