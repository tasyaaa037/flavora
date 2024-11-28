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
                    // Menentukan rute berdasarkan nama kategori
                    $routeInfo = [
                        'Cara Memasak' => ['route' => 'recipes.byMethod', 'parameter' => 'method'],
                        'Jenis Hidangan' => ['route' => 'recipes.byType', 'parameter' => 'type'],
                        'Kategori Khas' => ['route' => 'recipes.byCuisine', 'parameter' => 'cuisine'],
                        'Bahan Utama' => ['route' => 'recipes.byIngredient', 'parameter' => 'ingredient'],
                        'Tujuan Makanan' => ['route' => 'recipes.byPurpose', 'parameter' => 'purpose'],
                        'Rekomendasi Resep' => ['route' => 'recipes.byRecommendation', 'parameter' => 'recommendation'],
                    ];

                    // Tentukan rute dan parameter berdasarkan kategori tipe
                    $route = $routeInfo[$type->nama]['route'] ?? 'recipes.byCategorie';
                    $parameter = $routeInfo[$type->nama]['parameter'] ?? 'categorie';
                    $parameterValue = $categorie->nama;  // Nilai kategori berdasarkan nama
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
