@extends('layouts.bahan')

@section('content')
<div class="container mt-5">
    <div class="description text-center">
        <h3 class="fw-bold">Punya bahan apa di kulkas?</h3>
        <p class="text-muted">Kami akan beri rekomendasi resep sesuai dengan bahan yang kamu punya.</p>
    </div>
    <div class="row">
        <!-- Kolom Kiri: Pencarian dan Bahan -->
        <div class="col-md-4">
            <form id="ingredient-form" class="p-4 bg-light rounded shadow">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Pilih Bahan:</label>
                    <input type="text" id="search-box" class="form-control mb-3" placeholder="Cari bahan..." />

                    <div class="ingredient-list" style="max-height: 400px; overflow-y: auto;">
                        @foreach ($groupedIngredients as $letter => $ingredientsGroup)
                            <div class="mb-3 ingredient-group" data-letter="{{ $letter }}">
                                <h5 class="fw-bold">{{ $letter }}</h5>
                                <div class="row">
                                    @foreach($ingredientsGroup as $ingredient)
                                        <div class="col-12 mb-1">
                                            <div class="form-check">
                                                <input class="form-check-input ingredient-checkbox" type="checkbox" name="ingredients[]" value="{{ $ingredient->id }}" id="ingredient-{{ $ingredient->id }}">
                                                <label class="form-check-label" for="ingredient-{{ $ingredient->id }}">
                                                    {{ $ingredient->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>

        <!-- Kolom Kanan: Daftar Resep -->
        <div class="col-md-8">
            <div id="recipe-list" class="p-4 bg-white rounded shadow">
                <p id="recipe-count" class="text-muted"></p> <!-- Teks jumlah resep -->
                <div id="recipes">
                    <!-- Resep akan muncul di sini -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Event listener untuk input pencarian bahan
    $('#search-box').on('input', function() {
        let searchQuery = $(this).val().toLowerCase(); // Ambil query pencarian dalam huruf kecil

        // Jika kotak pencarian kosong, tampilkan semua bahan dan grup huruf
        if (searchQuery === '') {
            $('.ingredient-group').show(); // Tampilkan semua grup huruf
            $('.form-check').show(); // Tampilkan semua bahan
            $('.ingredient-list').find('.text-muted').remove(); // Hapus pesan "Bahan tidak ditemukan" jika ada
            return; // Hentikan fungsi di sini
        }

        let anyMatch = false; // Variabel untuk melacak apakah ada bahan yang cocok

        // Loop untuk setiap grup bahan
        $('.ingredient-group').each(function() {
            let group = $(this);
            let foundInGroup = false; // Untuk melacak bahan dalam grup ini

            // Periksa setiap bahan dalam grup
            group.find('.form-check').each(function() {
                let ingredientName = $(this).find('label').text().toLowerCase();
                if (ingredientName.indexOf(searchQuery) !== -1) {
                    $(this).show(); // Tampilkan bahan yang cocok
                    foundInGroup = true; // Set true jika ada bahan cocok dalam grup ini
                } else {
                    $(this).hide(); // Sembunyikan bahan yang tidak cocok
                }
            });

            // Tampilkan grup hanya jika ada bahan yang cocok di dalamnya
            if (foundInGroup) {
                group.show(); // Tampilkan grup ini
                anyMatch = true; // Set true jika ada bahan yang cocok
            } else {
                group.hide(); // Sembunyikan grup ini jika tidak ada bahan cocok
            }
        });

        // Tampilkan pesan jika tidak ada bahan yang cocok di seluruh grup
        if (!anyMatch) {
            // Hapus pesan sebelumnya agar tidak ada duplikat
            $('.ingredient-list').find('.text-muted').remove();
            $('.ingredient-list').append('<p class="text-center text-muted">Bahan tidak ditemukan. Coba kata kunci yang lain, ya.</p>');
        } else {
            // Hapus pesan jika ada bahan yang cocok
            $('.ingredient-list').find('.text-muted').remove();
        }
    });
});
</script>
@endsection
