@extends('layouts.tips')

@section('content')
<div class="container mb-5">
    <div class="heading_container heading_center mb-4">
        <h2>Edit Tips</h2>
    </div>

    <form action="{{ route('tips.update', $tip->id) }}" method="POST" enctype="multipart/form-data" class="p-5 border rounded shadow-lg" style="background-color: #f9fbfd;">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title" style="font-weight: bold;">Judul Tips</label>
            <input type="text" name="title" id="title" class="form-control form-control-lg shadow-sm" value="{{ old('title', $tip->title) }}" required style="border: 1px solid #ced4da; border-radius: 8px;">
        </div>
        
        <div class="form-group mt-4">
            <label for="description" style="font-weight: bold;">Deskripsi</label>
            <textarea name="description" id="description" class="form-control form-control-lg shadow-sm" rows="3" required style="border: 1px solid #ced4da; border-radius: 8px;">{{ old('description', $tip->description) }}</textarea>
        </div>
        
        <div class="form-group mt-4">
            <label for="steps" style="font-weight: bold;">Langkah-langkah</label>
            <textarea name="steps" id="steps" class="form-control form-control-lg shadow-sm" rows="5" required style="border: 1px solid #ced4da; border-radius: 8px;">{{ old('steps', $tip->steps) }}</textarea>
        </div>
        
        <div class="form-group mt-4">
            <label for="image" style="font-weight: bold;">Unggah Gambar</label>
            <input type="file" name="image" id="image" class="form-control shadow-sm" style="border: 1px solid #ced4da; border-radius: 8px;">
            <small class="form-text text-muted">*Kosongkan jika tidak ingin mengganti gambar.</small>
        </div>

        <div class="d-flex justify-content-between mt-5">
            <a href="{{ route('tips.index') }}" class="btn btn-secondary btn-lg shadow-sm" style="border-radius: 8px;">Kembali</a>
            <button type="submit" class="btn btn-primary btn-lg shadow-sm" style="border-radius: 8px; background-color: #007bff; border: none;">Perbarui Tips</button>
        </div>
    </form>
</div>