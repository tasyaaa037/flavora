@extends('layouts.kategoriresep')

@section('title', 'Flavora - Kategori Resep')

@section('content')
<div class="container">
    <div class="heading_container heading_center mb-4">
        <h2>Kategori Resep</h2>
    </div>

    <h3>Cara Memasak</h3>
    <ul>
        <li><a href="{{ route('recipes.byMethod', 'Serba Goreng') }}">Serba Goreng</a></li>
        <li><a href="{{ route('recipes.byMethod', 'Serba Kukus') }}">Serba Kukus</a></li>
        <li><a href="{{ route('recipes.byMethod', 'Serba Panggang & Bakar') }}">Serba Panggang & Bakar</a></li>
        <li><a href="{{ route('recipes.byMethod', 'Serba Rebus') }}">Serba Rebus</a></li>
        <li><a href="{{ route('recipes.byMethod', 'Serba Tumis') }}">Serba Tumis</a></li>
    </ul>

    <h3>Jenis Hidangan</h3>
    <ul>
        <li><a href="{{ route('recipes.byType', 'Makanan Pembuka') }}">Makanan Pembuka</a></li>
        <li><a href="{{ route('recipes.byType', 'Makanan Pendamping') }}">Makanan Pendamping</a></li>
        <li><a href="{{ route('recipes.byType', 'Makanan Penutup') }}">Makanan Penutup</a></li>
    </ul>

    <h3>Kategori Khas</h3>
    <ul>
        <li><a href="{{ route('recipes.byCuisine', 'Makanan Tradisional') }}">Makanan Tradisonal</a></li>
        <li><a href="{{ route('recipes.byCuisine', 'Makanan Internasional') }}">Makanan Internasional</a></li>
        <li><a href="{{ route('recipes.byCuisine', 'Makanan Cepat Saji') }}">Makanan Cepat Saji</a></li>
    </ul>

    <h3>Bahan Utama</h3>
    <ul>
        <li><a href="{{ route('recipes.byIngredient', 'Daging') }}">Daging</a></li>
        <li><a href="{{ route('recipes.byIngredient', 'Ikan & Seafood') }}">Ikan & Seafood</a></li>
        <li><a href="{{ route('recipes.byIngredient', 'Ayam') }}">Ayam</a></li>
        <li><a href="{{ route('recipes.byIngredient', 'Bebek') }}">Bebek</a></li>
        <li><a href="{{ route('recipes.byIngredient', 'Sayuran') }}">Sayuran</a></li>
        <li><a href="{{ route('recipes.byIngredient', 'Nasi & Karbohidrat') }}">Nasi & Karbohidrat</a></li>
    </ul>

    <h3>Tujuan Makanan</h3>
    <ul>
        <li><a href="{{ route('recipes.byPurpose', 'Makanan Diet/Sehat') }}">Makanan Diet/Sehat</a></li>
        <li><a href="{{ route('recipes.byPurpose', 'Makanan Anak') }}">Makanan Anak</a></li>
    </ul>
</div>
@endsection
