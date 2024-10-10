<div class="footer_container">
    <!-- Info Section -->
    <section class="info_section py-4">
        <div class="container">
            <div class="contact_box mb-3">
                <a href="#" class="text-decoration-none">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                </a>
                <a href="#" class="text-decoration-none">
                    <i class="fa fa-phone" aria-hidden="true"></i>
                </a>
                <a href="#" class="text-decoration-none">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                </a>
            </div>
            <div class="info_links mb-3">
                <ul class="list-inline">
                    <li class="list-inline-item active">
                        <a href="{{ url('/') }}" class="text-decoration-none">Beranda</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="{{ url('/about') }}" class="text-decoration-none">Resep</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="{{ url('/blog') }}" class="text-decoration-none">Kategori Resep</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="{{ url('/testimonial') }}" class="text-decoration-none">Tips&Trik</a>
                    </li>
                </ul>
            </div>
            <div class="container text-center ">
                <p>© <span id="displayYear"></span> Flavora</p>
            </div>
        </div>
    </section>
</div>
<script>
    document.getElementById('displayYear').innerText = new Date().getFullYear();
</script>
