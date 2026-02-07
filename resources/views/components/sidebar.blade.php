<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">Restoguh</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">PB</a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>

            {{-- Users --}}
            <li class="{{ Request::is('user*') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}" class="nav-link">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>

            {{-- Categories --}}
            <li class="{{ Request::is('categories*') ? 'active' : '' }}">
                <a href="{{ route('categories.index') }}" class="nav-link">
                    <i class="fas fa-tags"></i>
                    <span>Categories</span>
                </a>
            </li>

            {{-- Products with dropdown --}}
            <li class="nav-item dropdown {{ Request::is('product*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-box"></i>
                    <span>Products</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('product') ? 'active' : '' }}">
                        <a href="{{ route('product.index') }}" class="nav-link">All Products</a>
                    </li>
                </ul>
            </li>

            {{-- Orders --}}
            <li class="{{ Request::is('order*') ? 'active' : '' }}">
                <a href="{{ route('order.index') }}" class="nav-link">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </a>
            </li>

        </ul>
    </aside>
</div>
