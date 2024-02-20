<nav class="navbar navbar-expand-lg" style="background-color: #474F7A;">
    <div class="container px-4 px-lg-5">
        <p class="navbar-brand" style="color: white;">i S u r f f</p>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Move these buttons to the right -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    @auth
                    <a class="btn btn-outline-light mr-2" href="{{ route('front.cart') }}">
                        <i class="bi-cart-fill me-1"></i>
                        <span class="badge bg-dark text-white ms-1 rounded-pill">{{ count(auth()->user()->keranjang ?? []) }}</span>
                    </a>
                    @else
                    <!-- Tampilkan tombol cart tanpa jumlah saat pengguna belum terotentikasi -->
                    <a class="btn btn-outline-light mr-2" href="{{ route('front.cart') }}">
                        <i class="bi-cart-fill me-1"></i>
                    </a>
                    @endauth
                </li>
                <li class="nav-item">
                    @auth
                    <a class="btn btn-outline-light mr-2" href="{{ route('wishlist.index') }}">
                        <i class="bi-heart-fill me-1"></i>
                        <span class="badge bg-dark text-white ms-1 rounded-pill">{{ count(auth()->user()->wishlist ?? []) }}</span>
                    </a>
                    @else
                    <a class="btn btn-outline-light mr-2" href="{{ route('wishlist.index') }}">
                        <i class="bi-heart-fill me-1"></i>
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </a>
                    @endauth
                </li>
                <li class="nav-item">
                    @auth
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="bi-person-fill me-1"></span>
                        </button>
                        {{-- <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown link
                              </a> --}}

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('index.profile') }}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </div>
                    @else
                    <!-- Show Sign In link when the user is not authenticated -->
                    <a class="btn btn-outline-dark" href="{{ route('login') }}">
                        Sign In
                    </a>
                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>