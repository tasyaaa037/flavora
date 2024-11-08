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
                <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                @error('title')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Gambar Resep</label>
                <input type="file" id="image" name="image" accept="image/*" required>
                @error('image')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="time">Waktu (menit)</label>
                <input type="number" id="time" name="time" value="{{ old('time') }}" required>
                @error('time')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Harga (Rp)</label>
                <input type="number" id="price" name="price" value="{{ old('price') }}" required>
                @error('price')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="servings">Porsi</label>
                <input type="number" id="servings" name="servings" value="{{ old('servings') }}" required>
                @error('servings')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="ingredients">Bahan-bahan (Pisahkan dengan koma)</label>
                <textarea id="ingredients" name="ingredients" rows="4" required>{{ old('ingredients') }}</textarea>
                @error('ingredients')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="steps">Cara Memasak (Pisahkan dengan koma)</label>
                <textarea id="steps" name="steps" rows="4" required>{{ old('steps') }}</textarea>
                @error('steps')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit">Simpan Resep</button>
            </div>
        </form>
    </div>
</div>
@endsection
