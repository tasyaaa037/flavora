@extends('layouts.resep')

@section('title', 'Create Recipe')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Create New Recipe</h2>

    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form to create a new recipe -->
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

        <div class="form-group">
            <label for="ingredients">Ingredients</label>
            <textarea class="form-control" id="ingredients" name="ingredients[]" rows="5" placeholder="Enter each ingredient on a new line" required>{{ old('ingredients') }}</textarea>
        </div>

        <div class="form-group">
            <label for="instructions">Instructions</label>
            <textarea class="form-control" id="instructions" name="instructions[]" rows="5" placeholder="Enter each step on a new line" required>{{ old('instructions') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="cook_time" class="form-label">Cook Time (minutes)</label>
            <input type="number" name="cook_time" id="cook_time" class="form-control" value="{{ old('cook_time') }}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Recipe Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <!-- Category selection -->
        <div class="form-group">
            <label for="categorie">Category</label>
            <select name="categorie_id" class="form-control" required>
                @foreach($categorieTypes as $type)
                    <optgroup label="{{ $type->nama }}">
                        @foreach($type->categories as $categorie)
                            <option value="{{ $categorie->id }}">{{ $categorie->nama }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Create Recipe</button>
    </form>
</div>
@endsection
