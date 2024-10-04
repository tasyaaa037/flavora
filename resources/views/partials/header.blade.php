<div class="hero_area" style="position: relative;">
  <!-- header section starts -->
  <header class="header_section" style="position: relative;">
    <img src="{{ asset('delfood-1.0.0/images/hero-bg.jpg') }}" alt="Delfood" style="width: 100%; height: auto; position: absolute; top: 0; left: 0; z-index: 0;">
    <div class="container-fluid" style="position: relative; z-index: 1;">
      <nav class="navbar navbar-expand-lg custom_nav-container">
        <a class="navbar-brand" href="{{ url('/') }}">
          <span>
            Flavora
          </span>
        </a>
        <div class id>
          <div class="User_option">
                <a href="{{ route('login') }}">
                  <i class="fa fa-user" aria-hidden="true"></i>
                  <span>Login</span>
                </a>
                <form class="form-inline ">
                  <input type="search" placeholder="Search">
                  <button class="btn  nav_search-btn" type="submit">
                    <i class="fa fa-search" aria-hidden="true"></i>
                  </button>
                </form>
              </div>
              <div class="custom_menu-btn">
                <button onclick="openNav()">
                  <img src="{{ asset('delfood-1.0.0/images/menu.png') }}" alt="Menu">
                </button>
              </div>
              <div id="myNav" class="overlay">
                <div class="overlay-content">
                  <a href="index.html">Beranda</a>
                  <a href="about.html">Resep</a>
                  <a href="blog.html">Kategori Resep</a>
                  <a href="testimonial.html">Tips&Trik</a>
                </div>
              </div>
            </div>
      </nav>
    </div>
  </header>
  <!-- end header section -->
</div>
