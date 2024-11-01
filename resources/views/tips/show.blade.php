@extends('layouts.tips')

@section('content')
<div class="container mb-5">
    <div class="text-center mt-4 mb-4">
        <h1>{{ $tip->title }}</h1>
    </div>

    <div class="card shadow-sm">
        <img src="{{ asset($tip->image_url) }}" alt="{{ $tip->title }}" class="img-fluid rounded-top hd-image" style="height: 400px; object-fit: cover;">

        <div class="card-body">
            <h4 class="card-title">Deskripsi</h4>
            <p class="card-text">{{ $tip->description }}</p>

            <h4 class="card-title">Langkah-langkah</h4>
            <ol class="card-text" style="margin-bottom: 0;">
                @foreach(explode("\n", $tip->steps) as $step)
                    <li>{{ $step }}</li>
                @endforeach
            </ol>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('tips.index') }}" class="btn btn-secondary">Kembali</a>
            <div class="d-flex justify-content-end">
                <a href="{{ route('tips.edit', $tip->id) }}" class="btn btn-warning me-2 custom-btn">Edit</a>
                <form action="{{ route('tips.destroy', $tip->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus tips ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger custom-btn">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection