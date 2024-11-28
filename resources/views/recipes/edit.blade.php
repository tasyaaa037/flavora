@extends('layouts.resep')

@section('title', 'Edit Recipe')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Edit Recipe</h2>

    <!-- Displaying General Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Displaying Success or Error Messages from Session -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Recipe Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $recipe->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description', $recipe->description) }}</textarea>
        </div>

       <!-- Bahan-bahan -->
        <!-- Bahan-bahan -->
        <div class="form-group">
            <label for="ingredients">Bahan-bahan</label>
            <textarea class="form-control" id="ingredients" name="ingredients[]" rows="5" placeholder="Pisahkan setiap bahan dengan baris baru" required>{{ isset($recipe) ? implode("\n", explode(',', $recipe->ingredient)) : '' }}</textarea>
        </div>

        <!-- Langkah-langkah Memasak -->
        <div class="form-group">
            <label for="instructions">Cara Memasak</label>
            <textarea class="form-control" id="instructions" name="instructions[]" rows="5" placeholder="Pisahkan setiap langkah dengan baris baru" required>{{ isset($recipe) ? implode("\n", explode(',', $recipe->instructions)) : '' }}</textarea>
        </div>


        <div class="mb-3">
            <label for="cook_time" class="form-label">Cook Time (minutes)</label>
            <input type="number" name="cook_time" id="cook_time" class="form-control" value="{{ old('cook_time', $recipe->cook_time) }}" required>
        </div>

        <div class="mb-3">
            <label for="image">Recipe Image</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($recipe->image)
                <img src="{{ asset('storage/' . $recipe->image) }}" alt="Current Recipe Image" class="mt-2" width="200">
            @endif
        </div>

      <!-- Pilihan Kategori -->
        <div class="form-group">
            <label for="categorie">Kategori Resep</label>
            <select name="categorie_id" class="form-control" required>
                @foreach($categories as $type) <!-- Looping Categorietype -->
                    <optgroup label="{{ $type->nama }}"> <!-- Nama tipe kategori -->
                        @foreach($type->categories as $categorie) <!-- Looping Categorie berdasarkan tipe -->
                            <option value="{{ $categorie->id }}"
                                @if(isset($recipe) && $recipe->categorie_id == $categorie->id) selected @endif>
                                {{ $categorie->nama }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>


        <button type="submit" class="btn btn-primary mt-3">Update Recipe</button>
    </form>
</div>
<script>
$(document).ready(function() {
    var ingredientsList = [];
    var instructionsList = [];

    // Event listener untuk menambahkan bahan
    $('#ingredients').on('keypress', function(event) {
        if (event.which === 13) {  // Cek apakah tombol Enter ditekan
            event.preventDefault(); // Menghindari form submit
            var ingredient = $(this).val().trim();
            if (ingredient && !ingredientsList.includes(ingredient)) {
                ingredientsList.push(ingredient);
                $(this).val(''); // Bersihkan input setelah bahan dimasukkan
                updateIngredientList(); // Update daftar bahan
            }
        }
    });

    // Event listener untuk menambahkan langkah memasak
    $('#instructions').on('keypress', function(event) {
        if (event.which === 13) {  // Cek apakah tombol Enter ditekan
            event.preventDefault(); // Menghindari form submit
            var instruction = $(this).val().trim();
            if (instruction && !instructionsList.includes(instruction)) {
                instructionsList.push(instruction);
                $(this).val(''); // Bersihkan input setelah langkah dimasukkan
                updateInstructionList(); // Update daftar langkah
            }
        }
    });

    // Fungsi untuk memperbarui daftar bahan
    function updateIngredientList() {
        var listHtml = ingredientsList.map(function(ingredient) {
            return '<li>' + ingredient + '</li>';
        }).join('');
        $('#ingredients-list').html(listHtml);
        $('input[name="ingredients[]"]').val(ingredientsList); // Update input dengan array bahan
    }

    // Fungsi untuk memperbarui daftar langkah memasak
    function updateInstructionList() {
        var listHtml = instructionsList.map(function(instruction) {
            return '<li>' + instruction + '</li>';
        }).join('');
        $('#instructions-list').html(listHtml);
        $('input[name="instructions[]"]').val(instructionsList); // Update input dengan array langkah
    }

    // Ketika form disubmit, pastikan data yang dikirim dalam bentuk array
    $('form').submit(function() {
        $('input[name="ingredients[]"]').val(ingredientsList.join(','));
        $('input[name="instructions[]"]').val(instructionsList.join(','));
    });
});

</script>

@endsection
