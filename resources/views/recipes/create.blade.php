@extends('layouts.resep')

@section('title', 'Create Recipe')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Create New Recipe</h2>

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

    <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Recipe Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="instructions" class="form-label">Instructions</label>
            <div id="instructions-wrapper" class="mb-2">
                <input type="text" name="instructions[]" class="form-control mb-2" placeholder="Instruction Step" required>
            </div>
            <button type="button" class="btn btn-secondary" onclick="addInstruction()">Add Step</button>
        </div>

        <div class="mb-3">
            <label for="ingredient" class="form-label">Ingredients</label>
            <div id="ingredients-wrapper" class="mb-2">
                <div class="ingredient-group">
                    <input type="text" name="ingredients[0][name]" class="form-control mb-2" placeholder="Ingredient Name" required>
                    <input type="number" name="ingredients[0][quantity]" class="form-control mb-2" placeholder="Quantity" required>
                    <select name="ingredients[0][unit]" class="form-control mb-2" required>
                        <option value="">Select Unit</option>
                        <option value="grams">grams</option>
                        <option value="ml">ml</option>
                        <option value="pieces">pieces</option>
                        <option value="cups">cups</option>
                    </select>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" onclick="addIngredient()">Add Ingredient</button>
        </div>

        <div class="mb-3">
            <label for="cook_time" class="form-label">Cook Time (minutes)</label>
            <input type="number" name="cook_time" id="cook_time" class="form-control" value="{{ old('cook_time') }}" required>
        </div>

        <div class="mb-3">
            <label for="image">Recipe Image</label>
            <input type="file" name="image" id="image" class="form-control" required>
        </div>

        <!-- Category Dropdowns -->
        <div class="mb-3">
            <label for="cara_memasak" class="form-label">Cara Memasak</label>
            <select name="cara_memasak_id" id="cara_memasak" class="form-control">
                @foreach ($categorieTypes->where('nama', 'Cara Memasak')->first()->categories as $category)
                    <option value="{{ $category->id }}" {{ old('cara_memasak_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="jenis_hidangan" class="form-label">Jenis Hidangan</label>
            <select name="jenis_hidangan_id" id="jenis_hidangan" class="form-control">
                @foreach ($categorieTypes->where('nama', 'Jenis Hidangan')->first()->categories as $category)
                    <option value="{{ $category->id }}" {{ old('jenis_hidangan_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="kategori_khas" class="form-label">Kategori Khas</label>
            <select name="kategori_khas_id" id="kategori_khas" class="form-control">
                @foreach ($categorieTypes->where('nama', 'Kategori Khas')->first()->categories as $category)
                    <option value="{{ $category->id }}" {{ old('kategori_khas_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="bahan_utama" class="form-label">Bahan Utama</label>
            <select name="bahan_utama_id" id="bahan_utama" class="form-control">
                @foreach ($categorieTypes->where('nama', 'Bahan Utama')->first()->categories as $category)
                    <option value="{{ $category->id }}" {{ old('bahan_utama_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tujuan_makanan" class="form-label">Tujuan Makanan</label>
            <select name="tujuan_makanan_id" id="tujuan_makanan" class="form-control">
                @foreach ($categorieTypes->where('nama', 'Tujuan Makanan')->first()->categories as $category)
                    <option value="{{ $category->id }}" {{ old('tujuan_makanan_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Save Recipe</button>
    </form>
</div>

<script>
    let ingredientIndex = 1;
    let instructionIndex = 1;

    function addIngredient() {
        const wrapper = document.getElementById('ingredients-wrapper');
        const ingredientGroup = document.createElement('div');
        ingredientGroup.classList.add('ingredient-group');
        ingredientGroup.innerHTML = `
            <input type="text" name="ingredients[${ingredientIndex}][name]" placeholder="Ingredient Name" class="form-control mb-2" required>
            <input type="number" name="ingredients[${ingredientIndex}][quantity]" placeholder="Quantity" class="form-control mb-2" required>
            <select name="ingredients[${ingredientIndex}][unit]" class="form-control mb-2" required>
                <option value="">Select Unit</option>
                <option value="grams">grams</option>
                <option value="ml">ml</option>
                <option value="pieces">pieces</option>
                <option value="cups">cups</option>
            </select>
        `;
        wrapper.appendChild(ingredientGroup);
        ingredientIndex++; // Increment index for the next ingredient
    }

    function addInstruction() {
        const wrapper = document.getElementById('instructions-wrapper');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'instructions[]';
        input.placeholder = 'Instruction Step';
        input.classList.add('form-control', 'mb-2');
        wrapper.appendChild(input);
    }

</script>
@endsection
