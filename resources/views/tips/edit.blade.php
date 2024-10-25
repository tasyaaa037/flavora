@extends('layouts.tips')

@section('content')
<div class="container mb-5">
    <h1 class="text-center mt-4 mb-4">Edit Tips</h1>

    <form action="{{ route('tips.update', $tip->id) }}" method="POST" enctype="multipart/form-data" class="p-4 border rounded shadow-sm" style="background-color: #f8f9fa;">
        @csrf
        @method('PUT') <!-- Ini menandakan metode PUT untuk update -->

        <div class="form-group">
            <label for="title">Judul Tips</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $tip->title }}" required> <!-- Menampilkan data dari database -->
        </div>
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" rows="3" required>{{ $tip->description }}</textarea> <!-- Menampilkan deskripsi dari database -->
        </div>
        <div class="form-group">
            <label for="steps">Langkah-langkah</label>
            <textarea name="steps" id="steps" class="form-control" rows="5" required>{{ $tip->steps }}</textarea> <!-- Menampilkan langkah-langkah dari database -->
        </div>
        <div class="form-group">
            <label for="image">Unggah Gambar</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($tip->image_url)
                <img src="{{ asset($tip->image_url) }}" alt="{{ $tip->title }}" class="img-fluid mt-3" style="max-width: 200px;">
            @endif
            <!-- Menampilkan gambar jika sudah ada -->
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('tips.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Update Tips</button>
        </div>
    </form>
</div>
@endsection
