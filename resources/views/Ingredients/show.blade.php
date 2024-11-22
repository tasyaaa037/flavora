<!-- resources/views/ingredients/show.blade.php -->

@extends('layouts.bahan')  <!-- Assuming you have a main layout file -->

@section('content')
<div class="container">
    <h1>Ingredient Details</h1>

    <div class="ingredient-details">
        <h2>{{ $ingredient->name }}</h2>
        <p><strong>Category:</strong> {{ $ingredient->categorie->name ?? 'No category' }}</p>
        <p><strong>Description:</strong> {{ $ingredient->description ?? 'No description available' }}</p>
        <!-- You can display other ingredient details here -->
    </div>

    <a href="{{ route('ingredients.index') }}" class="btn btn-primary">Back to List</a>
</div>
@endsection
