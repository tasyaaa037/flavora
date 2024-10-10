@extends('layouts.kategoriresep')

@section('content')
    <div class="container">
        <h1>{{ $category->name }}</h1>

        <div class="row mb-4">
            @foreach($recipes as $recipe)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $recipe->name }}</h5>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('recipes.show', $recipe->id) }}" class="btn btn-primary float-end">Lihat Resep</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
