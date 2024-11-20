<body class="sub_page">

  <div class="hero_area">
    <!-- header section starts -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="{{ url('/') }}">
            <span>Flavora</span>
          </a>

          <style>
            .navbar-toggler {
              border-color: rgba(255, 255, 255, 0.1); /* Warna border tombol */
            }

            .navbar-toggler-icon {
              background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%28255, 255, 255, 1%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
              /* Warna ikon hamburger */
            }

            .dropdown-menu {
              min-width: 150px; /* Mengubah lebar dropdown */
            }

            .dropdown-item {
              font-size: 14px; /* Mengubah ukuran font item */
              padding: 8px 12px; /* Mengubah padding item */
            }

          </style>

          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">

              <li class="nav-item">
                <a class="nav-link text-white" href="{{ url('/recipes') }}">Semua Resep</a>
              </li>
              <!-- Dropdown Resep Makanan -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Kategori Resep
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <div class="d-flex flex-row justify-content-between">
                    <div class="mr-3">
                      <h6 class="dropdown-header">Jenis Hidangan</h6>
                      @foreach($categorieTypes as $type)
                        @if($type->nama == 'Jenis Hidangan')
                            @foreach($type->categories as $categorie)
                                <a class="dropdown-item" href="{{ route('recipes.byType', $categorie->nama) }}">{{ $categorie->nama }}</a>
                            @endforeach
                        @endif
                      @endforeach

                    </div>

                    <div class="mr-3">
                      <h6 class="dropdown-header">Cara Memasak</h6>
                      @foreach($categorieTypes as $type)
                        @if($type->nama == 'Cara Memasak')
                            @foreach($type->categories as $categorie)
                                <a class="dropdown-item" href="{{ route('recipes.byMethod', $categorie->nama) }}">{{ $categorie->nama }}</a>
                            @endforeach
                        @endif
                      @endforeach
                    </div>

                    <div class="mr-3">
                      <h6 class="dropdown-header">Bahan Utama</h6>
                      @foreach($categorieTypes as $type)
                        @if($type->nama == 'Bahan Utama')
                            @foreach($type->categories as $categorie)
                                <a class="dropdown-item" href="{{ route('recipes.byIngredient', $categorie->nama) }}">{{ $categorie->nama }}</a>
                            @endforeach
                        @endif
                      @endforeach
                    </div>

                    <div class="mr-3">
                      <h6 class="dropdown-header">Kategori Khas</h6>
                      @foreach($categorieTypes as $type)
                        @if($type->nama == 'Kategori Khas')
                            @foreach($type->categories as $categorie)
                                <a class="dropdown-item" href="{{ route('recipes.byCuisine', $categorie->nama) }}">{{ $categorie->nama }}</a>
                            @endforeach
                        @endif
                      @endforeach
                  </div>

                    <div class="mr-3">
                      <h6 class="dropdown-header">Tujuan Makanan</h6>
                      @foreach($categorieTypes as $type)
                        @if($type->nama == 'Tujuan Makanan')
                            @foreach($type->categories as $categorie)
                                <a class="dropdown-item" href="{{ route('recipes.byPurpose', $categorie->nama) }}">{{ $categorie->nama }}</a>
                            @endforeach
                        @endif
                      @endforeach
                    </div>

                    <div class="mr-3">
                      <h6 class="dropdown-header">Rekomendasi Resep</h6>
                      @foreach($categorieTypes as $type)
                        @if($type->nama == 'Rekomendasi Resep')
                            @foreach($type->categories as $categorie)
                                <a class="dropdown-item" href="{{ route('recipes.byRecommendation', $categorie->nama) }}">{{ $categorie->nama }}</a>
                            @endforeach
                        @endif
                      @endforeach
                    </div>
                  </div>
                </div>
              </li>

                <!-- Bahan Makanan -->
              <li class="nav-item">
                <a class="nav-link text-white" href="{{ url('/ingredients') }}">Bahan Makanan</a>
              </li>

              <!-- Kuliner -->
              <li class="nav-item">
                <a class="nav-link text-white" href="{{ url('/tips') }}">Tips & Triks</a>
              </li>
            </ul>
          </div>

          <!-- User Option -->
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

          <!-- Tombol Hamburger untuk Mobile -->
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>

  <script>
    function toggleSearch() {
      const searchContainer = document.querySelector('.search-container');
      const searchIcon = document.getElementById('searchIcon');

      if (searchContainer.style.display === 'none' || searchContainer.style.display === '') {
        searchContainer.style.display = 'flex';
        searchIcon.classList.remove('fa-search');
        searchIcon.classList.add('fa-times');
      } else {
        searchContainer.style.display = 'none';
        searchIcon.classList.remove('fa-times');
        searchIcon.classList.add('fa-search');
      }
    }
  </script>

</body>
