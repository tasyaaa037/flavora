@extends('layouts.bahan')

@section('content')
<div class="container">
    <h1>Recipes</h1>
    @if($recipes->isEmpty())
        <p>No recipes found for the selected ingredients.</p>
    @else
        <ul>
            @foreach($recipes as $recipe)
                <li>{{ $recipe->name }}</li>
            @endforeach
        </ul>
    @endif
    <a href="{{ route('ingredients.index') }}" class="btn btn-secondary">Back to Search</a>
</div>
@endsection
