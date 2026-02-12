<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand" style="height: auto; padding: 20px 0; line-height: normal;">
            <a href="{{ auth()->check() ? url('/home') : url('/') }}"
               style="display: block; width: 100%; text-transform: none; letter-spacing: normal;">
               {{-- Gunakan props untuk menyesuaikan ukuran khusus sidebar --}}
                <img src="https://ik.imagekit.io/8wuwjawgk/casdd__1_-removebg-preview.png"
                                 alt="Restoguh Logo"
                                 width="160"
                                 class="logo-img"
                                 style="display: block; margin: 0 auto; border: none; outline: none;">
            </a>
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

            {{-- Products --}}
            <li class="{{ Request::is('product*') ? 'active' : '' }}">
                <a href="{{ route('product.index') }}" class="nav-link">
                    <i class="fas fa-box"></i>
                    <span>Products</span>
                </a>
            </li>


            {{-- Orders --}}
            <li class="{{ Request::is('order*') ? 'active' : '' }}">
                <a href="{{ route('order.index') }}" class="nav-link">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </a>
            </li>


            {{-- Products with dropdown --}}
            <li class="{{ Request::is('settings*') ? 'active' : '' }}">
                <a href="{{ route('settings.index') }}" class="nav-link">
                    <i class="fa-solid fa-gear"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
