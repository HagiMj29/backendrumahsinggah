<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Menu</div>
                    <a class="nav-link {{ Route::is('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-solid fa-person"></i></div>
                        User Tabel
                    </a>
                    {{-- <a class="nav-link {{ Route::is('category.index') ? 'active' : '' }}"
                        href="{{ route('category.index') }}">
                        <div class="sb-nav-link-icon "><i class="fas fa-solid fa-list"></i></div>
                        Categories
                    </a>
                    <a class="nav-link {{ Route::is('product.index') ? 'active' : '' }}"
                        href="{{ route('product.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-solid fa-shop"></i></div>
                        Product
                    </a>
                    <a class="nav-link" {{ Route::is('order.index') ? 'active' : '' }}"
                        href="{{ route('order.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-solid fa-circle-down"></i></div>
                        Order
                    </a>
                    <a class="nav-link" href="index.html">
                        <div class="sb-nav-link-icon"><i class="fas fa-solid fa-dollar-sign"></i></div>
                        Payments
                    </a>
                    <a class="nav-link" href="index.html">
                        <div class="sb-nav-link-icon"><i class="fas fa-solid fa-cart-shopping"></i></div>
                        Carts
                    </a> --}}
                </div>
            </div>
        </nav>
    </div>
