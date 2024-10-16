<body class="sub_page">

  <div class="hero_area">
    <!-- header section starts -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="{{ url('/') }}">
            <span>Flavora</span>
          </a>
          <div class="User_option">
          @auth
          <a href="{{ route('profile.show') }}" class="text-teal-500">
              {{ Auth::user()->name }}
          </a>
              
            <!-- Tambahkan form logout dengan metode POST -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>

            <!-- Tombol logout yang menggunakan form POST -->
            <a href="#" class="btn btn-outline-danger ml-2" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              Keluar
            </a>

          @else
            <a href="{{ route('login') }}" class="btn btn-outline-primary">
              <i class="fa fa-user" aria-hidden="true"></i>
              Masuk
            </a>
          @endauth
        </div>

        <div class="custom_menu-btn">
          <button onclick="openNav()">
            <img src="{{ asset('delfood-1.0.0/images/menu.png') }}" alt="Menu">
          </button>
        </div>

        <div id="myNav" class="overlay">
          <div class="overlay-content">
            <a href="{{ url('/') }}">Beranda</a>
            <a href="{{ url('/recipes') }}">Resep</a>
            <a href="{{ url('/subcategories') }}">Kategori Resep</a>
            <a href="{{ url('/tips') }}">Tips & Trik</a>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <!-- end header section -->
</div>
