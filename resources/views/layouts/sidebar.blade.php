<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Menu</div>
                    <a class="nav-link {{ Route::is('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-solid fa-person"></i></div>
                        Users Tabel
                    </a>
                    <a class="nav-link {{ Route::is('homestay.index') ? 'active' : '' }}"
                        href="{{ route('homestay.index') }}">
                        <div class="sb-nav-link-icon "><i class="fas fa fa-home"></i></div>
                        Homestays
                    </a> 
                    <a class="nav-link {{ Route::is('room.index') ? 'active' : '' }}"
                        href="{{ route('room.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa fa-bed"></i></div>
                        Rooms
                    </a>
                    <a class="nav-link {{ Route::is('booking.index') ? 'active' : '' }}"
                        href="{{ route('booking.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-solid fa-circle-down"></i></div>
                        Booking
                    </a>
                    <a class="nav-link {{ Route::is('review.index') ? 'active' : '' }}"
                        href="{{ route('review.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-solid fa-circle-down"></i></div>
                        Review
                    </a>
                    {{-- <a class="nav-link" href="index.html">
                        <div class="sb-nav-link-icon"><i class="fas fa-solid fa-cart-shopping"></i></div>
                        Carts
                    </a>  --}}
                </div>
            </div>
        </nav>
    </div>
