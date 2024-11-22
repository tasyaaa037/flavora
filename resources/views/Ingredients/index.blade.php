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

                    <div id="ingredient-list" class="ingredient-list" style="max-height: 400px; overflow-y: auto;">
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

        if (searchQuery.length > 0) {
            $.ajax({
                url: '{{ route('ingredients.search') }}', // Route untuk mencari bahan
                type: 'GET',
                data: { search: searchQuery }, // Kirimkan query pencarian ke server
                success: function(response) {
                    // Menyembunyikan semua grup bahan terlebih dahulu
                    $('.ingredient-group').each(function() {
                        let groupName = $(this).data('letter').toLowerCase(); // Ambil huruf grup bahan
                        if (groupName.indexOf(searchQuery) === -1) {
                            $(this).hide(); // Sembunyikan grup jika tidak cocok
                        } else {
                            $(this).show(); // Tampilkan grup jika cocok
                            // Menyembunyikan bahan dalam grup yang tidak cocok dengan pencarian
                            $(this).find('.form-check').each(function() {
                                let ingredientName = $(this).find('label').text().toLowerCase();
                                if (ingredientName.indexOf(searchQuery) === -1) {
                                    $(this).hide(); // Sembunyikan bahan yang tidak cocok
                                } else {
                                    $(this).show(); // Tampilkan bahan yang cocok
                                }
                            });
                        }
                    });
                },
                error: function() {
                    // Menangani error pencarian
                    console.log('Error searching ingredients');
                }
            });
        } else {
            // Jika input kosong, tampilkan semua bahan
            $('.ingredient-group').show();
            $('.form-check').show();
        }
    });

    // Event listener untuk checkbox bahan
    $('.ingredient-checkbox').on('change', function() {
        let selectedIngredients = [];

        // Mengumpulkan semua checkbox yang dicentang
        $('.ingredient-checkbox:checked').each(function() {
            selectedIngredients.push($(this).val());
        });

        // Kirim request ke server untuk mendapatkan resep berdasarkan bahan yang dipilih
        $.ajax({
            url: '{{ route('ingredients.search') }}', // Route untuk mencari resep
            type: 'GET',
            data: { ingredients: selectedIngredients }, // Data yang dikirim ke server
            success: function(response) {
                // Update jumlah resep
                $('#recipe-count').text(`Menampilkan ${response.recipes.length} resep dari total ${response.total} untuk bahan yang dipilih`);

                // Update daftar resep
                $('#recipes').html(response.recipeHtml); // Pastikan respons berisi HTML untuk daftar resep
            },
            error: function() {
                $('#recipe-count').text('Gagal memuat resep.');
                $('#recipes').html('');
            }
        });
    });
});
</script>
@endsection
