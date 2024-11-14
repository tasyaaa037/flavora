
@extends('layouts.bahan')

@section('title', 'Hasil Pencarian Resep')

@section('content')
<div class="container">
    <h2 class="text-center mt-4">Resep dengan bahan: {{ implode(', ', $selectedIngredients) }}</h2>

    @if($recipes->isEmpty())
        <p class="text-center mt-4">Maaf, tidak ada resep yang cocok dengan bahan yang dipilih.</p>
    @else
        <div class="recipe-list mt-4">
            @foreach($recipes as $recipe)
                <div class="recipe-item p-3 mb-3 border rounded">
                    <h4>{{ $recipe->name }}</h4>
                    <p>{{ $recipe->description }}</p>
                    <a href="{{ route('ingredients.show', ['id' => $ingredient->id]) }}">View Ingredient</a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
