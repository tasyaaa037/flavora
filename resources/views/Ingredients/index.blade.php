@extends('layouts.bahan')

@section('title', 'Bahan Masakan')

@section('content')
<div class="container">
    <div class="sidebar">
        <input placeholder="Bahan apa yang kamu punya?" type="text" class="p-2 border rounded" />
        <div class="mt-4 p-2 bg-orange-100 text-orange-600 rounded-lg" id="selected-count">
            0 bahan telah terpilih
        </div>
        <ul id="ingredient-list">
            @php
                $ingredientsMap = [
                    'A' => ['Agar-Agar', 'Air Kelapa', 'Air Soda', 'Almond', 'Alpukat', 'Anggur', 'Apel', 'Asam Jawa', 'Asparagus', 'Ati Ampela', 'Ayam', 'Ayam Cincang', 'Acar', 'Acar Mentimun'],
                    'B' => ['Baby Corn', 'Bacon', 'Baking Powder', 'Bakso', 'Bakso Ikan', 'Basil', 'Bawang Bombay', 'Bawang Merah', 'Bawang Putih', 'Bayam', 'Belimbing', 'Belut', 'Bengkoang', 'Beras', 'Beras Ketan', 'Beras Merah', 'Bihun', 'Biskuit Oreo', 'Blewah', 'Blueberry', 'Brokoli', 'Buah Naga', 'Bubble Pearl', 'Bubuk Jelly', 'Buncis', 'Bunga Lawang/Pekak', 'Bay Leaf', 'Biji Wijen'],
                    'C' => ['Cabai', 'Cabai Bubuk', 'Caju', 'Cake Flour', 'Cantaloupe', 'Capcay', 'Caramel', 'Cengkeh', 'Ceri', 'Coconut Cream', 'Cokelat', 'Cokelat Bubuk', 'Cakalang', 'Cumi-cumi', 'Cappuccino'],
                    'D' => ['Daging Ayam', 'Daging Kambing', 'Daging Sapi', 'Daun Bawang', 'Daun Jeruk', 'Durian', 'Daun Salam', 'Duku', 'Dendeng'],
                    'E' => ['Es Batu', 'Edamame', 'Emping', 'Enoki', 'Elderberry', 'Eel', 'Escargot'],
                    'F' => ['Fennel', 'Fillet Ikan', 'Fish Sauce', 'Fusilli', 'Feta Cheese', 'Fudge'],
                    'G' => ['Garam', 'Gula', 'Ginger', 'Gulaman', 'Gula Aren', 'Ginseng'],
                    'H' => ['Havermut', 'Himalaya Salt', 'Honey', 'Horiatiki Salad', 'Hummus', 'Hazelnut'],
                    'I' => ['Ikan', 'Ikan Salmon', 'Ikan Tuna', 'Ikan Gurame', 'Ikan Lele', 'Ikan Kembung', 'Ice Cream', 'Ikan Teri'],
                    'J' => ['Jagung', 'Jamur', 'Jahe', 'Jeruk', 'Jelly', 'Jus', 'Jus Jeruk', 'Jus Mangga', 'Jeruk Nipis', 'Jeruk Bali'],
                    'K' => ['Kacang', 'Kacang Hijau', 'Kacang Merah', 'Kacang Tanah', 'Kacang Polong', 'Kepala Ikan', 'Kepala Udang', 'Kepala Ayam', 'Kecap', 'Kecap Manis', 'Kecap Asin', 'Kedondong', 'Kefir', 'Kembang Kol', 'Kembang Tahu', 'Kecambah', 'Kacang Almond', 'Kacang Mete'],
                    'L' => ['Labu', 'Lemon', 'Lentil', 'Lobak', 'Lobster', 'Luwak Coffee', 'Lada Hitam', 'Lada Putih', 'Langka', 'Lettuce', 'Lidah Buaya', 'Lemon Balm'],
                    'M' => ['Madu', 'Makaroni', 'Mangga', 'Mangga Muda', 'Mangga Manis', 'Marmalade', 'Melon', 'Mie', 'Miso', 'Mocca', 'Moringa', 'Mentega', 'Mushroom'],
                    'N' => ['Nanas', 'Nasi', 'Nasi Goreng', 'Nasi Kuning', 'Nasi Uduk', 'Nori', 'Nugget', 'Nutmeg'],
                    'O' => ['Oatmeal', 'Oregano', 'Olive', 'Olive Oil', 'Onion', 'Orange Juice', 'Oreo', 'Oregano'],
                    'P' => ['Pasta', 'Pepper', 'Peterseli', 'Pisang', 'Pudina', 'Puding', 'Puyuh', 'Puyuh Rebus', 'Puyuh Goreng', 'Puyuh Penyet', 'Puyuh Bakar', 'Puyuh Kecap', 'Paprika', 'Paprika Merah'],
                    'R' => ['Roti', 'Roti Bakar', 'Roti Maryam', 'Roti Manis', 'Roti Tawar', 'Roti Pizza', 'Roti Tortilla', 'Roti Pisang', 'Roti Ubi', 'Rumput Laut', 'Rendang'],
                    'S' => ['Salmon', 'Sambal', 'Sawi', 'Sawi Putih', 'Sawi Hijau', 'Sayur', 'Susu', 'Saus Tiram', 'Sereh'],
                    'T' => ['Tahu', 'Tempe', 'Telur', 'Tempe', 'Tepung', 'Tomat', 'Tumis', 'Tuna', 'Tumis Sayuran', 'Tumis Tempe', 'Terasi', 'Tepung Roti'],
                    'U' => ['Udang', 'Ubi', 'Ubi Jalar', 'Ubi Kuning', 'Ubi Manis', 'Umeshu', 'Udang Rebus'],
                    'V' => ['Vanilla', 'Vegetable Oil', 'Vermicelli', 'Vinegar'],
                    'W' => ['Wortel', 'Wortel Merah', 'Wortel Putih', 'Wagyu'],
                    'X' => ['Xanthan Gum'],
                    'Y' => ['Yam', 'Yogurt', 'Yakult'],
                    'Z' => ['Zaitun', 'Zucchini'],
                ];
            @endphp

            @foreach(range('A', 'Z') as $char)
                <h3 class="font-bold mb-2">{{ $char }}</h3>
                <ul class="mb-4">
                    @if(isset($ingredientsMap[$char]) && count($ingredientsMap[$char]) > 0)
                    @foreach ($ingredients as $ingredient)
                        <a href="{{ route('ingredients.show', ['ingredient' => $ingredient->id]) }}">View Ingredient</a>
                    @endforeach

                    @else
                        <li class="text-gray-500">No ingredients available for {{ $char }}</li>
                    @endif
                </ul>
            @endforeach

        </ul>

        <!-- Ingredient Form -->
        <form id="ingredient-form" action="{{ route('ingredients.show') }}" method="GET">
            <input type="hidden" name="ingredients[]" id="ingredients-input" />
            <button type="submit" class="btn btn-primary mt-4">Cari Resep</button>
        </form>
    </div>

    <div class="col-md-8 d-flex flex-column align-items-center justify-content-center" style="min-height: 70vh; margin: auto;">
        <div class="illustration mb-3">
            <img alt="Ilustrasi Perempuan Memasak" height="300" src="https://i.pinimg.com/736x/c6/6c/37/c66c3772afe98ae3c590340198ce01fc.jpg" width="300" class="img-fluid rounded" />
        </div>
        <div class="description text-center">
            <h3 class="fw-bold">Punya bahan apa di kulkas?</h3>
            <p class="text-muted">Kami akan beri rekomendasi resep sesuai dengan bahan yang kamu punya.</p>
        </div>
    </div>
</div>

<script>
    function updateSelectedCount() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        const selectedIngredients = Array.from(checkboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.id.replace('ingredient-', '').replace(/-/g, ' '));

        document.getElementById('selected-count').innerText = `${selectedIngredients.length} bahan telah terpilih`;
        document.getElementById('ingredients-input').value = JSON.stringify(selectedIngredients);
    }
</script>
@endsection
