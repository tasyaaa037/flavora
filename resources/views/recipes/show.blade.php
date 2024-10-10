@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $recipe->title }}</h1>

    <!-- Menampilkan gambar resep -->
    @if($recipe->image_path)
        <img src="{{ asset($recipe->image_path) }}" alt="{{ $recipe->title }}" class="img-fluid">
    @else
        <p>Tidak ada gambar untuk resep ini.</p>
    @endif

    <p>{{ $recipe->description }}</p>

    <h2>Komentar:</h2>
    @foreach($comments as $comment)
        <div class="comment">
            <strong>{{ $comment->user->name }}:</strong>
            <p>{{ $comment->content }}</p>
        </div>
    @endforeach
</div>
@endsection
