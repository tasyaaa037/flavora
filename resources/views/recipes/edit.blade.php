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
        @method('PUT') <!-- This method is used to indicate the update operation -->

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
            @if(is_array($recipe->instructions))
                @foreach($recipe->instructions as $index => $instruction)
                    <input type="text" name="instructions[]" class="form-control mb-2" value="{{ old('instructions.' . $index, $instruction) }}" placeholder="Instruction Step" required>
                @endforeach
            @else
                <p>Data tidak valid untuk instructions</p>
            @endif

            </div>
            <button type="button" class="btn btn-secondary" onclick="addInstruction()">Add Step</button>
        </div>

        <div class="mb-3">
            <label for="ingredient" class="form-label">Ingredients</label>
            <div id="ingredients-wrapper" class="mb-2">
                @if(is_array($recipe->ingredients))
                    @foreach($recipe->ingredients as $index => $ingredient)
                        <div class="ingredient-group">
                            <input type="text" name="ingredients[{{ $index }}][name]" class="form-control mb-2" value="{{ old('ingredients.' . $index . '.name', $ingredient['name'] ?? '') }}" placeholder="Ingredient" required>
                            <input type="number" name="ingredients[{{ $index }}][quantity]" class="form-control mb-2" value="{{ old('ingredients.' . $index . '.quantity', $ingredient['quantity'] ?? '') }}" placeholder="Quantity" required>
                            <select name="ingredients[{{ $index }}][unit]" class="form-control mb-2" required>
                                <option value="">Select Unit</option>
                                <option value="grams" {{ old('ingredients.' . $index . '.unit', $ingredient['unit'] ?? '') == 'grams' ? 'selected' : '' }}>grams</option>
                                <option value="ml" {{ old('ingredients.' . $index . '.unit', $ingredient['unit'] ?? '') == 'ml' ? 'selected' : '' }}>ml</option>
                                <option value="pieces" {{ old('ingredients.' . $index . '.unit', $ingredient['unit'] ?? '') == 'pieces' ? 'selected' : '' }}>pieces</option>
                                <option value="cups" {{ old('ingredients.' . $index . '.unit', $ingredient['unit'] ?? '') == 'cups' ? 'selected' : '' }}>cups</option>
                            </select>
                        </div>
                    @endforeach
                @else
                    <p>Data ingredients tidak tersedia.</p>
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
                <p>Current Image: <img src="{{ asset('storage/' . $recipe->image) }}" alt="Recipe Image" class="img-thumbnail" width="150"></p>
            @endif
        </div>

        <!-- Category Dropdowns -->
        <div class="mb-3">
            <label for="cara_memasak" class="form-label">Cara Memasak</label>
            <select name="cara_memasak_id" id="cara_memasak" class="form-control" required>
                @foreach ($categories->where('categorie_type_id', 1) as $categorie)
                    <option value="{{ $categorie->id }}" {{ old('cara_memasak_id', $recipe->cara_memasak_id) == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="jenis_hidangan" class="form-label">Jenis Hidangan</label>
            <select name="jenis_hidangan_id" id="jenis_hidangan" class="form-control" required>
                @foreach ($categories->where('categorie_type_id', 2) as $categorie)
                    <option value="{{ $categorie->id }}" {{ old('jenis_hidangan_id', $recipe->jenis_hidangan_id) == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="kategori_khas" class="form-label">Kategori Khas</label>
            <select name="kategori_khas_id" id="kategori_khas" class="form-control" required>
                @foreach ($categories->where('categorie_type_id', 3) as $categorie)
                    <option value="{{ $categorie->id }}" {{ old('kategori_khas_id', $recipe->kategori_khas_id) == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="bahan_utama" class="form-label">Bahan Utama</label>
            <select name="bahan_utama_id" id="bahan_utama" class="form-control" required>
                @foreach ($categories->where('categorie_type_id', 4) as $categorie)
                    <option value="{{ $categorie->id }}" {{ old('bahan_utama_id', $recipe->bahan_utama_id) == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tujuan_makanan" class="form-label">Tujuan Makanan</label>
            <select name="tujuan_makanan_id" id="tujuan_makanan" class="form-control" required>
                @forelse ($categories->where('categorie_type_id', 5) as $categorie) <!-- Pastikan kategori tujuan_makanan memiliki categorie_type_id yang benar -->
                    <option value="{{ $categorie->id }}" {{ old('tujuan_makanan_id', $recipe->tujuan_makanan_id) == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nama }}
                    </option>
                @empty
                    <option value="">No Categories Available</option>
                @endforelse
            </select>
        </div>


        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>

<script>
    // Function to dynamically add new instruction fields
    function addInstruction() {
        var newInstruction = document.createElement("input");
        newInstruction.type = "text";
        newInstruction.name = "instructions[]";
        newInstruction.classList.add("form-control", "mb-2");
        newInstruction.placeholder = "Instruction Step";
        document.getElementById("instructions-wrapper").appendChild(newInstruction);
    }

    // Function to dynamically add new ingredient fields
    function addIngredient() {
        var ingredientGroup = document.createElement("div");
        ingredientGroup.classList.add("ingredient-group");

        var nameInput = document.createElement("input");
        nameInput.type = "text";
        nameInput.name = "ingredients[][name]";
        nameInput.classList.add("form-control", "mb-2");
        nameInput.placeholder = "Ingredient";

        var quantityInput = document.createElement("input");
        quantityInput.type = "number";
        quantityInput.name = "ingredients[][quantity]";
        quantityInput.classList.add("form-control", "mb-2");
        quantityInput.placeholder = "Quantity";

        var unitSelect = document.createElement("select");
        unitSelect.name = "ingredients[][unit]";
        unitSelect.classList.add("form-control", "mb-2");

        // Add options for unit select
        var units = ["grams", "ml", "pieces", "cups"];
        units.forEach(unit => {
            var option = document.createElement("option");
            option.value = unit;
            option.text = unit;
            unitSelect.appendChild(option);
        });

        ingredientGroup.appendChild(nameInput);
        ingredientGroup.appendChild(quantityInput);
        ingredientGroup.appendChild(unitSelect);

        document.getElementById("ingredients-wrapper").appendChild(ingredientGroup);
    }
</script>
@endsection
