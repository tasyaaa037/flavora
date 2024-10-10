@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Resep dengan Cara Memasak: {{ request()->route('method') }}</h2>

    <div class="row">
        @foreach($recipes as $recipe)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $recipe->title }}</h5>
                        <p class="card-text">{{ $recipe->description }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('recipes.show', $recipe->id) }}" class="btn btn-primary">Lihat Resep</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
