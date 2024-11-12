@extends('layouts.kategoriresep')

@section('title', 'Flavora - Kategori Resep')

@section('content')
<div class="container">
    <div class="heading_container heading_center mb-4">
        <h2>Kategori Resep</h2>
    </div>

    @foreach($categorieTypes as $type)
        <h3>{{ $type->nama }}</h3>
        <ul>
            @foreach($type->categories as $categorie)
                @php
                    // Tentukan route yang sesuai berdasarkan tipe kategori
                    switch($type->nama) {
                        case 'Cara Memasak':
                            $route = 'recipes.byMethod';  // Pastikan rute ini ada di web.php
                            $parameter = 'method';  // Sesuaikan dengan parameter yang dibutuhkan
                            $parameterValue = $categorie->nama;  // Misalnya nama metode
                            break;
                        case 'Jenis Hidangan':
                            $route = 'recipes.byType';  // Pastikan rute ini ada di web.php
                            $parameter = 'type';
                            $parameterValue = $categorie->nama;  // Misalnya tipe kategori berdasarkan ID
                            break;
                        case 'Kategori Khas':
                            $route = 'recipes.byCuisine';  // Pastikan rute ini ada di web.php
                            $parameter = 'cuisine';
                            $parameterValue = $categorie->nama;  // Misalnya kategori berdasarkan ID
                            break;
                        case 'Bahan Utama':
                            $route = 'recipes.byIngredient';  // Pastikan rute ini ada di web.php
                            $parameter = 'ingredient';
                            $parameterValue = $categorie->nama;  // Misalnya bahan utama berdasarkan ID
                            break;
                        case 'Tujuan Makanan':
                            $route = 'recipes.byPurpose';  // Pastikan rute ini ada di web.php
                            $parameter = 'purpose';
                            $parameterValue = $categorie->nama;  // Misalnya tujuan makanan berdasarkan ID
                            break;
                        case 'Rekomendasi Resep':
                            $route = 'recipes.byRecommendation';  // Pastikan rute ini ada di web.php
                            $parameter = 'recommendation';
                            $parameterValue = $categorie->nama;  // Misalnya rekomendasi resep berdasarkan ID
                            break;
                        default:
                            $route = 'recipes.byCategorie';  // Default route ke 'recipes.byCategorie'
                            $parameter = 'categorie';
                            $parameterValue = $categorie->nama;
                    }
                @endphp

                <li>
                    <a href="{{ route($route, [$parameter => $parameterValue]) }}">
                        {{ $categorie->nama }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endforeach
</div>
@endsection
