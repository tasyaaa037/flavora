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
        <h2>Recipes using {{ $ingredient->name }}</h2>
            @if($recipes->count())
                <ul>
                    @foreach ($recipes as $recipe)
                        <li>{{ $recipe->title }}</li>
                    @endforeach
                </ul>
            @else
                <p>No recipes found for this ingredient.</p>
            @endif
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

 // Event listener untuk centang bahan
 $('.ingredient-checkbox').on('change', function() {
        updateRecipeList();
    });

    function updateRecipeList() {
        let selectedIngredients = [];
        $('.ingredient-checkbox:checked').each(function() {
            selectedIngredients.push($(this).val());
        });

        // Kirim AJAX untuk mendapatkan resep berdasarkan bahan yang dicentang
        $.ajax({
            url: '/get-recipes',  // Ganti dengan URL rute yang sesuai
            method: 'POST',
            data: {
                ingredients: selectedIngredients,
                _token: $('input[name="_token"]').val()  // Untuk keamanan CSRF
            },
            success: function(response) {
                displayRecipes(response);
            },
            error: function() {
                $('#recipes').html('<p class="text-center text-danger">Gagal memuat resep. Coba lagi nanti.</p>');
            }
        });
    }

    function displayRecipes(data) {
        let html = '';

        if (data.length === 0) {
            html = '<p class="text-center text-muted">Tidak ada resep yang cocok dengan bahan yang dipilih.</p>';
        } else {
            data.forEach(recipe => {
                html += `
                    <div class="recipe-item mb-3">
                        <h5>${recipe.name}</h5>
                        <p>Bahan yang diperlukan: ${recipe.ingredients.join(', ')}</p>
                        ${recipe.missingIngredients.length > 0 ? `<p class="text-danger">Bahan yang kurang: ${recipe.missingIngredients.join(', ')}</p>` : ''}
                    </div>
                `;
            });
        }

        $('#recipes').html(html);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const ingredientItems = document.querySelectorAll('.ingredient-item');

        ingredientItems.forEach(item => {
            item.addEventListener('click', function() {
                const ingredientId = this.getAttribute('data-ingredient-id');
                fetch(`/ingredients/${ingredientId}/recipes`)  // Endpoint API Laravel
                    .then(response => response.json())
                    .then(data => {
                        displayRecipes(data);
                    })
                    .catch(error => console.error('Error fetching recipes:', error));
            });
        });

        function displayRecipes(recipes) {
            const recipeContainer = document.getElementById('recipes');
            const recipeCount = document.getElementById('recipe-count');

            recipeContainer.innerHTML = '';  // Kosongkan daftar sebelumnya

            if (recipes.length === 0) {
                recipeCount.textContent = 'Tidak ada resep dengan bahan ini.';
                return;
            }

            recipeCount.textContent = `${recipes.length} resep ditemukan:`;

            recipes.forEach(recipe => {
                const recipeCard = `
                    <div class="card mb-3">
                        <img src="/delfood-1.0.0/images/${recipe.image}" class="card-img-top" alt="${recipe.title}">
                        <div class="card-body">
                            <h5 class="card-title">${recipe.title}</h5>
                            <p class="card-text">${recipe.description}</p>
                            <a href="/recipes/${recipe.id}" class="btn btn-primary">Lihat Resep</a>
                        </div>
                    </div>
                `;
                recipeContainer.innerHTML += recipeCard;
            });
        }
    });
    $(document).ready(function() {
    $('#ingredient-search').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{ route('ingredients.search') }}",
                data: { term: request.term },
                success: function(data) {
                    response(data);  // Data berupa array nama bahan
                }
            });
        },
        select: function(event, ui) {
            // Ketika bahan dipilih, tambahkan ke daftar bahan
            var selectedIngredients = $('#ingredient-list').val();
            selectedIngredients = selectedIngredients ? selectedIngredients + ',' + ui.item.value : ui.item.value;
            $('#ingredient-list').val(selectedIngredients);
            $('#ingredient-search').val('');
            return false;
        }
    });
});

});
</script>
@endsection
