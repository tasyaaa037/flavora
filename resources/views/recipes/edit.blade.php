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

        <div class="mb-3">
            <label for="instructions" class="form-label">Instructions</label>
            <div id="instructions-wrapper" class="mb-2">
            @if(!empty($recipe->instructions) && is_array($recipe->instructions))
                @foreach($recipe->instructions as $instruction)
                    <input type="text" name="instructions[]" class="form-control mb-2" value="{{ $instruction }}" required>
                @endforeach
            @else
                <input type="text" name="instructions[]" class="form-control mb-2" placeholder="Add a step" required>
            @endif

            </div>
            <button type="button" class="btn btn-secondary" onclick="addInstruction()">Add Step</button>
        </div>

        <div class="mb-3">
            <label for="ingredient" class="form-label">Ingredients</label>
            <div id="ingredients-wrapper" class="mb-2">
                @if(is_array($recipe->ingredients) || is_object($recipe->ingredients))
                    @foreach($recipe->ingredients as $index => $ingredient)
                        <div class="ingredient-group">
                            <input type="text" name="ingredients[{{ $index }}][name]" class="form-control mb-2" 
                                value="{{ old("ingredients.$index.name", $ingredient['name'] ?? '') }}" 
                                placeholder="Ingredient Name" required>
                            <input type="number" name="ingredients[{{ $index }}][quantity]}" class="form-control mb-2" 
                                value="{{ old("ingredients.$index.quantity", $ingredient['quantity'] ?? '') }}" 
                                placeholder="Quantity" required>
                            <select name="ingredients[{{ $index }}][unit]}" class="form-control mb-2" required>
                                <option value="grams" {{ old("ingredients.$index.unit", $ingredient['unit'] ?? '') == 'grams' ? 'selected' : '' }}>grams</option>
                                <option value="ml" {{ old("ingredients.$index.unit", $ingredient['unit'] ?? '') == 'ml' ? 'selected' : '' }}>ml</option>
                                <option value="pieces" {{ old("ingredients.$index.unit", $ingredient['unit'] ?? '') == 'pieces' ? 'selected' : '' }}>pieces</option>
                                <option value="cups" {{ old("ingredients.$index.unit", $ingredient['unit'] ?? '') == 'cups' ? 'selected' : '' }}>cups</option>
                            </select>
                        </div>
                    @endforeach
                @else
                    <p>No ingredients available.</p>
                @endif
            </div>

            <button type="button" class="btn btn-secondary" onclick="addIngredient()">Add Ingredient</button>
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

        <!-- Category Dropdowns -->
        @php
            $categories = [
                'cara_memasak' => 'Cara Memasak',
                'jenis_hidangan' => 'Jenis Hidangan',
                'kategori_khas' => 'Kategori Khas',
                'bahan_utama' => 'Bahan Utama',
                'tujuan_makanan' => 'Tujuan Makanan',
            ];
        @endphp

        @foreach ($categories as $field => $label)
            <div class="mb-3">
                <label for="{{ $field }}" class="form-label">{{ $label }}</label>
                <select name="{{ $field }}_id" id="{{ $field }}" class="form-control">
                    @foreach ($categorieTypes->where('nama', $label)->first()->categories as $category)
                        <option value="{{ $category->id }}" {{ old("{$field}_id", $recipe->{$field . '_id'}) == $category->id ? 'selected' : '' }}>
                            {{ $category->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary mt-3">Update Recipe</button>
    </form>
</div>

<script>
    function addIngredient() {
        let ingredientIndex = document.querySelectorAll('.ingredient-group').length;
        let ingredientWrapper = document.getElementById('ingredients-wrapper');
        
        let newIngredientHTML = `
            <div class="ingredient-group">
                <input type="text" name="ingredients[${ingredientIndex}][name]" class="form-control mb-2" placeholder="Ingredient Name" required>
                <input type="number" name="ingredients[${ingredientIndex}][quantity]" class="form-control mb-2" placeholder="Quantity" required>
                <select name="ingredients[${ingredientIndex}][unit]" class="form-control mb-2" required>
                    <option value="grams">grams</option>
                    <option value="ml">ml</option>
                    <option value="pieces">pieces</option>
                    <option value="cups">cups</option>
                </select>
            </div>
        `;
        
        ingredientWrapper.insertAdjacentHTML('beforeend', newIngredientHTML);
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
