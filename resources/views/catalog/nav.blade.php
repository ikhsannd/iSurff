<header id="header" class="site-header header-scrolled fixed-top text-black bg-light" style="position: relative;">
  <nav style="background-color: #474F7A" id="header-nav" class="navbar navbar-expand-lg px-5 py-3">
    <div class="container-fluid">
      <a class="navbar-brand" style="color: white; font-family: 'Poppins';" href="{{ route('front.index') }}">
        @php
        $words = explode(' ', $setting->nama_perusahaan);
        $word = '';
        foreach ($words as $w) {
        $word .= $w[0];
        }
        @endphp
        <span class="logo-lg " style="font-size: 32px;"><b>{{ $setting->nama_perusahaan }}</b></span></a>
      <button class="navbar-toggler d-flex d-lg-none order-3 p-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#bdNavbar" aria-controls="bdNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <svg class="navbar-icon">
          <use xlink:href="#navbar-icon"></use>
        </svg>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="bdNavbar" aria-labelledby="bdNavbarOffcanvasLabel">
        <div class="offcanvas-header px-4 pb-0">
          <a class="navbar-brand" href="index.html">
            <img src="{{asset('catalog/images/main-logo.png')}}" class="logo">
          </a>
          <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas" aria-label="Close" data-bs-target="#bdNavbar"></button>
        </div>
        <div class="offcanvas-body">
          <ul id="navbar" class="navbar-nav text-uppercase justify-content-end align-items-center flex-grow-1 pe-3">
            <li class="nav-item">
              <div class="user-items ps-5">
                <ul class="d-flex justify-content-end list-unstyled">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <svg class="user">
                        <use xlink:href="#user"></use>
                      </svg>
                    </a>
                    @auth
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{ route('index.profile') }}">Profile</a>
                      <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                    </div>
                    @else
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                    </div>
                  </li>
                  @endauth
                  <li class="pe-3 align-items-center d-flex">
                    <a href="{{route('wishlist.index')}}">
                      <svg class="star-half">
                        <use xlink:href="#star-half"></use>
                      </svg>
                    </a>
                    <span class="badge bg-dark text-white ms-1 rounded-pill">{{ count(auth()->user()->wishlist ?? []) }}</span>
                  </li>
                  <li class="pe-3 align-items-center d-flex">
                    <a href="{{route('front.cart')}}">
                      <svg class="cart">
                        <use xlink:href="#cart"></use>
                      </svg>
                    </a>
                    <span class="badge bg-dark text-white ms-1 rounded-pill">{{ count(auth()->user()->keranjang ?? []) }}</span>
                  </li>
                  <li class="pe-3 align-items-center d-flex">
                    <a href="{{route('front.pesanan')}}">
                      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-3">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                          <path fill-rule="evenodd" clip-rule="evenodd" style="fill: white;" d="M5.58579 4.58579C5 5.17157 5 6.11438 5 8V17C5 18.8856 5 19.8284 5.58579 20.4142C6.17157 21 7.11438 21 9 21H15C16.8856 21 17.8284 21 18.4142 20.4142C19 19.8284 19 18.8856 19 17V8C19 6.11438 19 5.17157 18.4142 4.58579C17.8284 4 16.8856 4 15 4H9C7.11438 4 6.17157 4 5.58579 4.58579ZM9 8C8.44772 8 8 8.44772 8 9C8 9.55228 8.44772 10 9 10H15C15.5523 10 16 9.55228 16 9C16 8.44772 15.5523 8 15 8H9ZM9 12C8.44772 12 8 12.4477 8 13C8 13.5523 8.44772 14 9 14H15C15.5523 14 16 13.5523 16 13C16 12.4477 15.5523 12 15 12H9ZM9 16C8.44772 16 8 16.4477 8 17C8 17.5523 8.44772 18 9 18H13C13.5523 18 14 17.5523 14 17C14 16.4477 13.5523 16 13 16H9Z" fill="#222222"></path>
                        </g>
                      </svg>
                    </a>
                    <span class="badge bg-dark text-white ms-1 rounded-pill">{{ count(auth()->user()->order ?? []) }}</span>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</header>