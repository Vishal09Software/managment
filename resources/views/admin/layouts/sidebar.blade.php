<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? '' : 'collapsed' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('users.*') ? '' : 'collapsed' }}" href="{{ route('users.index') }}">
                <i class="bi bi-people"></i>
                <span>User Management</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('customers.*') ? '' : 'collapsed' }}" href="{{ route('customers.index') }}">
                <i class="bi bi-person-lines-fill"></i>
                <span>Customer Management</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('vendors.*') ? '' : 'collapsed' }}" href="{{ route('vendors.index') }}">
                <i class="bi bi-shop"></i>
                <span>Vendor Management</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('products.*') ? '' : 'collapsed' }}" href="{{ route('products.index') }}">
                <i class="bi bi-box"></i>
                <span>Product Management</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('vehicles.*') ? '' : 'collapsed' }}" href="{{ route('vehicles.index') }}">
                <i class="bi bi-truck"></i>
                <span>Vehicle Management</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('sales.*') ? '' : 'collapsed' }}" href="{{ route('sales.index') }}">
                <i class="bi bi-cart"></i>
                <span>Sales Management</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('taxes.*') ? '' : 'collapsed' }}" data-bs-target="#settings-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-gear"></i><span>Settings</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="settings-nav" class="nav-content {{ request()->routeIs('taxes.*') ? 'show' : 'collapse' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a class="{{ request()->routeIs('taxes.*') ? 'active' : '' }}" href="{{ route('taxes.index') }}">
                        <i class="bi bi-circle"></i><span>Tax Settings</span>
                    </a>
                </li>

            </ul>
        </li>
    </ul>
</aside><!-- End Sidebar-->
