@extends('layouts.resep')

@section('content')
<div class="container">
    <div class="row">
        <!-- Sidebar Bahan -->
        <div class="col-md-3">
            <div class="form-group">
                <label for="search">Bahan apa yang kamu punya?</label>
                <input type="text" class="form-control" id="search" placeholder="Cari bahan...">
            </div>
            <h5>Bahan Populer Minggu Ini</h5>
            <ul class="list-unstyled">
                <li>
                    <input type="checkbox" id="sosis" class="bahan-checkbox" value="Sosis">
                    <label for="sosis">Sosis</label>
                </li>
                <li>
                    <input type="checkbox" id="tahu" class="bahan-checkbox" value="Tahu">
                    <label for="tahu">Tahu</label>
                </li>
                <li>
                    <input type="checkbox" id="telur" class="bahan-checkbox" value="Telur">
                    <label for="telur">Telur</label>
                </li>
            </ul>
            <h5>Bahan Lainnya</h5>
            <ul class="list-unstyled">
                <li>
                    <input type="checkbox" id="agar" class="bahan-checkbox" value="Agar-Agar">
                    <label for="agar">Agar-Agar</label>
                </li>
                <li>
                    <input type="checkbox" id="air_kelapa" class="bahan-checkbox" value="Air Kelapa">
                    <label for="air_kelapa">Air Kelapa</label>
                </li>
            </ul>
        </div>

        <!-- Rekomendasi Resep -->
        <div class="col-md-9">
            <h3>Punya bahan apa di kulkas?</h3>
            <p>Kami akan beri rekomendasi resep sesuai dengan bahan yang kamu punya.</p>
            <div id="resep-container">
                <!-- Rekomendasi resep akan ditampilkan di sini -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// JavaScript untuk menangkap bahan yang dipilih dan meminta rekomendasi resep
document.querySelectorAll('.bahan-checkbox').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        // Ambil semua bahan yang dipilih
        let selectedBahan = [];
        document.querySelectorAll('.bahan-checkbox:checked').forEach(function(checkedBox) {
            selectedBahan.push(checkedBox.value);
        });

        // Kirim request ke server untuk mendapatkan resep berdasarkan bahan
        fetch('/resep/rekomendasi', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({bahan: selectedBahan})
        })
        .then(response => response.json())
        .then(data => {
            // Tampilkan resep yang direkomendasikan
            displayResep(data);
        });
    });
});

// Fungsi untuk menampilkan rekomendasi resep
function displayResep(resep) {
    const resepContainer = document.getElementById('resep-container');
    resepContainer.innerHTML = ''; // Kosongkan resep sebelumnya
    resep.forEach(item => {
        resepContainer.innerHTML += `
            <div class="resep-item mb-3">
                <h4>${item.title}</h4>
                <p>${item.description}</p>
                <img src="${item.image}" alt="${item.title}" style="width: 200px; height: auto;">
            </div>
        `;
    });
}
</script>
@endsection
