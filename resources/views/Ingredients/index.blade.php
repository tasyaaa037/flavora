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
                // Map of ingredients categorized by the starting letter
                $ingredientsMap = [
                    'A' => ['Agar-Agar', 'Air Kelapa', 'Air Soda', 'Almond', 'Alpukat', 'Anggur', 'Apel', 'Asam Jawa', 'Asparagus', 'Ati Ampela', 'Ayam', 'Ayam Cincang'],
                    'B' => ['Baby Corn', 'Bacon', 'Baking Powder', 'Bakso', 'Bakso Ikan', 'Basil', 'Bawang Bombay', 'Bawang Merah', 'Bawang Putih', 'Bayam', 'Belimbing', 'Belut', 'Bengkoang', 'Beras', 'Beras Ketan', 'Beras Merah', 'Bihun', 'Biskuit Oreo', 'Blewah', 'Blueberry', 'Brokoli', 'Buah Naga', 'Bubble Pearl', 'Bubuk Jelly', 'Buncis', 'Bunga Lawang/Pekak'],
                    'C' => ['Cabai', 'Cabai Bubuk', 'Caju', 'Cake Flour', 'Cantaloupe', 'Capcay', 'Caramel', 'Cengkeh', 'Ceri', 'Coconut Cream', 'Cokelat', 'Cokelat Bubuk'],
                    'D' => ['Daging Ayam', 'Daging Kambing', 'Daging Sapi', 'Daun Bawang', 'Daun Jeruk', 'Durian'],
                    'E' => ['Es Batu', 'Edamame', 'Emping', 'Enoki', 'Elderberry'],
                    'F' => ['Fennel', 'Fillet Ikan', 'Fish Sauce', 'Fusilli'],
                    'G' => ['Garam', 'Gula', 'Ginger', 'Gulaman'],
                    'H' => ['Havermut', 'Himalaya Salt', 'Honey', 'Horiatiki Salad', 'Hummus'],
                    'I' => ['Ikan', 'Ikan Salmon', 'Ikan Tuna', 'Ikan Gurame', 'Ikan Lele', 'Ikan Kembung'],
                    'J' => ['Jagung', 'Jamur', 'Jahe', 'Jeruk', 'Jelly', 'Jus', 'Jus Jeruk', 'Jus Mangga'],
                    'K' => ['Kacang', 'Kacang Hijau', 'Kacang Merah', 'Kacang Tanah', 'Kacang Polong', 'Kepala Ikan', 'Kepala Udang', 'Kepala Ayam', 'Kecap', 'Kecap Manis', 'Kecap Asin', 'Kedondong', 'Kefir', 'Kembang Kol', 'Kembang Tahu', 'Kecambah'],
                    'L' => ['Labu', 'Lemon', 'Lentil', 'Lobak', 'Lobster', 'Luwak Coffee', 'Lada Hitam', 'Lada Putih', 'Langka', 'Lettuce', 'Lidah Buaya'],
                    'M' => ['Madu', 'Makaroni', 'Mangga', 'Mangga Muda', 'Mangga Manis', 'Marmalade', 'Melon', 'Mie', 'Miso', 'Mocca', 'Moringa'],
                    'N' => ['Nanas', 'Nasi', 'Nasi Goreng', 'Nasi Kuning', 'Nasi Uduk', 'Nori', 'Nugget'],
                    'O' => ['Oatmeal', 'Oregano', 'Olive', 'Olive Oil', 'Onion', 'Orange Juice', 'Oreo'],
                    'P' => ['Pasta', 'Pepper', 'Peterseli', 'Pisang', 'Pudina', 'Puding', 'Puyuh', 'Puyuh Rebus', 'Puyuh Goreng', 'Puyuh Penyet', 'Puyuh Bakar', 'Puyuh Kecap'],
                    'R' => ['Roti', 'Roti Bakar', 'Roti Maryam', 'Roti Manis', 'Roti Tawar', 'Roti Pizza', 'Roti Tortilla', 'Roti Pisang', 'Roti Ubi'],
                    'Q' => [''],
                    'S' => ['Salmon', 'Sambal', 'Sawi', 'Sawi Putih', 'Sawi Hijau', 'Sayur'],
                    'T' => ['Tahu', 'Tahu Tempe', 'Telur', 'Tempe', 'Tepung', 'Tomat', 'Tumis', 'Tuna', 'Tumis Sayuran', 'Tumis Tempe'],
                    'U' => ['Udang', 'Ubi', 'Ubi Jalar', 'Ubi Kuning', 'Ubi Manis', 'Umeshu'],
                    'V' => ['Vanilla', 'Vegetable Oil', 'Vermicelli'],
                    'W' => ['Wortel', 'Wortel Merah', 'Wortel Putih'],
                    'X' => ['Xanthan Gum'],
                    'Y' => ['Yam', 'Yogurt'],
                    'Z' => ['Zaitun', 'Zucchini'],
                ];
            @endphp
            
            @foreach(range('A', 'Z') as $char)
                <h3 class="font-bold mb-2">{{ $char }}</h3>
                <ul class="mb-4">
                    @foreach($ingredientsMap[$char] as $ingredient)
                        <li class="flex items-center mb-2">
                            <span class="flex-1">{{ $ingredient }}</span>
                            <input type="checkbox" id="ingredient-{{ strtolower($ingredient) }}" onchange="updateSelectedCount()" />
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </ul>
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
        const selectedCount = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;
        document.getElementById('selected-count').innerText = `${selectedCount} bahan telah terpilih`;
    }
</script>
@endsection
