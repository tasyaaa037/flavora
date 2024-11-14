@extends('layouts.resep')

@section('content')
<div class="container">
    <h2>Edit Recipe</h2>

    <form action="{{ route('recipes.update', $recipe->id) }}" method="POST" class="recipe-form">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ $recipe->title }}" required class="form-control">
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ $recipe->description }}</textarea>
        </div>

        <!-- Ingredients -->
        <h4>Ingredients</h4>
        <div id="ingredients-wrapper" class="form-group">
            @foreach ($recipe->ingredients as $ingredient)
                <div class="ingredient-group">
                    <input type="text" name="ingredients[][name]" value="{{ $ingredient->name }}" placeholder="Ingredient Name" class="form-control mb-2">
                    <input type="number" name="ingredients[][quantity]" value="{{ $ingredient->quantity }}" placeholder="Quantity" class="form-control mb-2">
                    <select name="ingredients[][unit]" class="form-control mb-2">
                        <option value="grams" {{ $ingredient->unit == 'grams' ? 'selected' : '' }}>grams</option>
                        <option value="ml" {{ $ingredient->unit == 'ml' ? 'selected' : '' }}>ml</option>
                        <option value="pieces" {{ $ingredient->unit == 'pieces' ? 'selected' : '' }}>pieces</option>
                        <option value="cups" {{ $ingredient->unit == 'cups' ? 'selected' : '' }}>cups</option>
                    </select>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-primary" onclick="addIngredient()">Add Ingredient</button>

        <!-- Instructions -->
        <h4>Instructions</h4>
        <div class="form-group">
            <label for="instructions">Instructions (each step on a new line)</label>
            <textarea name="instructions" id="instructions" class="form-control" rows="6">{{ implode("\n", $recipe->instructions) }}</textarea>
        </div>

        <!-- Cook Time -->
        <div class="form-group">
            <label for="cook_time">Cook Time (minutes)</label>
            <input type="number" name="cook_time" id="cook_time" value="{{ $recipe->cook_time }}" class="form-control">
        </div>

        <!-- Image URL -->
        <div class="form-group">
            <label for="image">Image URL</label>
            <input type="text" name="image" id="image" value="{{ $recipe->image }}" placeholder="Image URL" class="form-control">
        </div>

        <!-- Category -->
        <label for="categorie_id">Category</label>
        <select name="categorie_id" required class="form-control">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $recipe->categorie_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-success">Update Recipe</button>
    </form>
</div>

<script>
    function addIngredient() {
        const wrapper = document.getElementById('ingredients-wrapper');
        const ingredientGroup = document.createElement('div');
        ingredientGroup.classList.add('ingredient-group');
        ingredientGroup.innerHTML = `
            <input type="text" name="ingredients[][name]" placeholder="Ingredient Name" class="form-control mb-2">
            <input type="number" name="ingredients[][quantity]" placeholder="Quantity" class="form-control mb-2">
            <select name="ingredients[][unit]" class="form-control mb-2">
                <option value="grams">grams</option>
                <option value="ml">ml</option>
                <option value="pieces">pieces</option>
                <option value="cups">cups</option>
            </select>
        `;
        wrapper.appendChild(ingredientGroup);
    }
</script>
@endsection
