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
        <div class="form-group">
            <label for="ingredients">Bahan-bahan</label>
            <textarea name="ingredients" id="ingredients" class="form-control" required>{{ $recipe->ingredient }}</textarea>
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