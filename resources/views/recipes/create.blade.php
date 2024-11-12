@extends('layouts.resep')

@section('content')
<style>
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ced4da;
    }

    .btn-submit {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .btn-submit:hover {
        background-color: #0056b3;
    }
</style>

<div class="container">
    <h1>Tambah Resep Baru</h1>

    <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Title -->
        <div class="form-group">
            <label for="title">Judul Resep</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
        </div>

        <!-- Instructions -->
        <div class="form-group">
            <label for="instructions">Instruksi Memasak</label>
            <textarea name="instructions" id="instructions" class="form-control" rows="4" placeholder="Langkah-langkah memasak" required></textarea>
        </div>

        <!-- Time -->
        <div class="form-group">
            <label for="time">Waktu Masak (menit)</label>
            <input type="number" name="time" id="time" class="form-control" required>
        </div>

        <!-- Image Upload -->
        <div class="form-group">
            <label for="image">Upload Gambar</label>
            <input type="file" name="image" id="image" class="form-control" required>
        </div>

        <!-- Ingredients Selection -->
        <!-- Bahan-bahan -->
        <div class="form-group">
            <label for="ingredients">Bahan-bahan</label>
            <textarea name="ingredients" id="ingredients" class="form-control" rows="3" placeholder="Masukkan bahan-bahan, pisahkan dengan koma" required></textarea>
            <small>Pisahkan dengan koma.</small>
        </div>


        <!-- Category Selection -->
        <div class="form-group">
            <label for="categorie_type">Kategori Resep</label>

            <!-- Cooking Method Category -->
            <div class="form-group">
                <label for="cooking_method">Cara Memasak</label>
                <select name="categories[cooking_method]" id="cooking_method" class="form-control">
                    <option value="">Pilih Cara Memasak</option>
                    @foreach ($cookingMethods as $categorie)
                        <option value="{{ $categorie->id }}">{{ $categorie->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Dish Type Category -->
            <div class="form-group">
                <label for="dish_type">Jenis Hidangan</label>
                <select name="categories[dish_type]" id="dish_type" class="form-control">
                    <option value="">Pilih Jenis Hidangan</option>
                    @foreach ($dishTypes as $categorie)
                        <option value="{{ $categorie->id }}">{{ $categorie->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Specialty Category -->
            <div class="form-group">
                <label for="specialty">Kategori Khas</label>
                <select name="categories[specialty]" id="specialty" class="form-control">
                    <option value="">Pilih Kategori Khas</option>
                    @foreach ($specialties as $categorie)
                        <option value="{{ $categorie->id }}">{{ $categorie->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Main Ingredient Category -->
            <div class="form-group">
                <label for="main_ingredient">Bahan Utama</label>
                <select name="categories[main_ingredient]" id="main_ingredient" class="form-control">
                    <option value="">Pilih Bahan Utama</option>
                    @foreach ($mainIngredients as $categorie)
                        <option value="{{ $categorie->id }}">{{ $categorie->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Purpose Category -->
            <div class="form-group">
                <label for="purpose">Tujuan Makanan</label>
                <select name="categories[purpose]" id="purpose" class="form-control">
                    <option value="">Pilih Tujuan Makanan</option>
                    @foreach ($purposes as $categorie)
                        <option value="{{ $categorie->id }}">{{ $categorie->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" class="btn-submit">Simpan Resep</button>
    </form>
</div>
@endsection
