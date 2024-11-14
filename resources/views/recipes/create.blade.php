@extends('layouts.resep')

@section('title', 'Create Recipe')

@section('content')
<div class="container">
    <h2>Create New Recipe</h2>

    <!-- Menampilkan Pesan Error Umum -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Menampilkan Pesan Sukses atau Error dari Session -->
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
    <div>
        <label for="title">Recipe Title</label>
        <input type="text" name="title" id="title" value="{{ old('title') }}">
    </div>

    <div>
        <label for="description">Description</label>
        <textarea name="description" id="description">{{ old('description') }}</textarea>
    </div>

    <div>
        <label for="instructions">Instructions</label>
        <textarea name="instructions" id="instructions">{{ old('instructions') }}</textarea>
    </div>

    <div>
        <label for="ingredient">Ingredients</label>
        <textarea name="ingredient" id="ingredient">{{ old('ingredient') }}</textarea>
    </div>

    <div>
        <label for="cook_time">Cook Time (minutes)</label>
        <input type="number" name="cook_time" id="cook_time" value="{{ old('cook_time') }}">
    </div>

    <div>
        <label for="image">Recipe Image</label>
        <input type="file" name="image" id="image">
    </div>

    <!-- Separate dropdowns for each category type -->
    <div>
        <label for="cara_memasak">Cara Memasak</label>
        <select name="cara_memasak_id" id="cara_memasak">
            @foreach ($categorieTypes->where('nama', 'Cara Memasak')->first()->categories as $category)
                <option value="{{ $category->id }}" {{ old('cara_memasak_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="jenis_hidangan">Jenis Hidangan</label>
        <select name="jenis_hidangan_id" id="jenis_hidangan">
            @foreach ($categorieTypes->where('nama', 'Jenis Hidangan')->first()->categories as $category)
                <option value="{{ $category->id }}" {{ old('jenis_hidangan_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="kategori_khas">Kategori Khas</label>
        <select name="kategori_khas_id" id="kategori_khas">
            @foreach ($categorieTypes->where('nama', 'Kategori Khas')->first()->categories as $category)
                <option value="{{ $category->id }}" {{ old('kategori_khas_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="bahan_utama">Bahan Utama</label>
        <select name="bahan_utama_id" id="bahan_utama">
            @foreach ($categorieTypes->where('nama', 'Bahan Utama')->first()->categories as $category)
                <option value="{{ $category->id }}" {{ old('bahan_utama_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="tujuan_makanan">Tujuan Makanan</label>
        <select name="tujuan_makanan_id" id="tujuan_makanan">
            @foreach ($categorieTypes->where('nama', 'Tujuan Makanan')->first()->categories as $category)
                <option value="{{ $category->id }}" {{ old('tujuan_makanan_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit">Save Recipe</button>
</form>

</div>
<script>
    let ingredientIndex = 1;

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
        input.classList.add('form-control', 'mb-2', 'instruction-step');
        wrapper.appendChild(input);
    }
</script>
@endsection
