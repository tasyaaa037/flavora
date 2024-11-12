@extends('layouts.resep')

@section('content')
<style>
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        padding: 20px;
        box-sizing: border-box;
    }

    .form-container {
        width: 100%;
        max-width: 800px;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
        margin-bottom: 10px;
        display: block;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        font-size: 14px;
    }

    .form-group textarea {
        resize: vertical;
    }

    .form-group input[type="file"] {
        padding: 5px;
    }

    .form-group button {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 15px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
        transition: all 0.3s ease;
    }

    .form-group button:hover {
        background-color: #218838;
    }

    .form-group .error {
        color: red;
        font-size: 12px;
    }

    .alert {
        padding: 15px;
        margin: 10px 0;
        border-radius: 5px;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }
</style>

<div class="container">
    <div class="form-container">
        <h1>Tambah Resep</h1>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Judul Resep</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="category">Kategori</label>
                <select class="form-control" id="category" name="categorie_id" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="image">Gambar</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>

            <div class="form-group">
                <label for="prep_time">Waktu Persiapan (menit)</label>
                <input type="number" class="form-control" id="prep_time" name="prep_time" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Resep</button>
        </form>

    </div>
</div>
@endsection
