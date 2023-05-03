<li class="nav-item menu-open">
    <a href="{{ '/' }}" class="nav-link active">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>

<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-database"></i>
        <p>
            Master Data
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('jenis-obat.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Jenis Obat</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="pages/charts/chartjs.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Stok Obat</p>
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
    <a href="" class="nav-link">
        <i class="nav-icon fas fa-cog"></i>
        <p>
            Setting
        </p>
    </a>
</li>
