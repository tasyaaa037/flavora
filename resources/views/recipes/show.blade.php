@extends('layouts.resep')

@section('content')
<style>
    /* Membuat responsive container */
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        padding: 20px;
        box-sizing: border-box;
    }

    .recipe-details {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
        margin-bottom: 50px;
    }

    .recipe-image {
        flex: 0 0 100%;
        margin-top: 20px;
    }

    @media (min-width: 768px) {
        .recipe-details {
            flex-direction: row;
        }
        .recipe-image {
            flex: 0 0 400px;
        }
    }

    .img-fluid {
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        width: 100%;
        height: auto;
        max-width: 800px;
    }

    .icon-section {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin-top: 10px;
        gap: 10px;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .action-button {
        background-color: #f8f9fa;
        border: 2px solid #ced4da;
        color: #495057;
        border-radius: 5px;
        padding: 10px 15px;
        font-size: 14px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .action-button:hover {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .edit-btn {
        background-color: #28a745;
    }

    .delete-btn {
        background-color: #dc3545;
    }

    .tabs {
        width: 100%;
        margin-top: 20px;
    }

    .tab-content {
        margin-top: 20px;
    }

    .list-group {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        padding: 0;
        list-style: none;
        margin: 0;
    }

    .list-group-item {
        padding: 10px;
        border: 1px solid #ddd;
        margin-bottom: 5px;
        border-radius: 5px;
        text-align: center;
        background-color: #f9f9f9;
        cursor: pointer;
    }

    .list-group-item:hover {
        background-color: #007bff;
        color: white;
    }
</style>

<div class="container">
    <div class="recipe-details">
        <div class="recipe-image">
            <img src="{{ asset('delfood-1.0.0/images/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="img-fluid">
        </div>
        <div>
            <h1>{{ $recipe->title }}</h1>
            <div class="description">
                <p>{{ $recipe->description }}</p>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('recipes.edit', ['recipe' => $recipe->id]) }}">Edit Recipe</a>

                <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus resep ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-button delete-btn">
                        <i class="fa fa-trash"></i> Hapus Resep
                    </button>
                </form>
            </div>

            <!-- Tabs for Bahan, Cara Memasak, and Diskusi -->
            <div class="tabs">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#bahan" data-toggle="tab">Bahan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#cara-memasak" data-toggle="tab">Cara Memasak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#diskusi" data-toggle="tab">Testi Diskusi</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="bahan">
                        <h2>Bahan-bahan</h2>
                        <p>{{ $recipe->ingredient }}</p>
                    </div>
                    <div class="tab-pane fade" id="cara-memasak">
                        <h2>Cara Memasak</h2>
                        <p>{{ $recipe->instructions }}</p> <!-- Displaying instructions directly without a separate table -->
                    </div>

                    <div class="tab-pane fade" id="diskusi">
                        <h2>Komentar</h2>
                        <div>
                            @foreach($recipe->comments as $comment)
                                <div class="comment">
                                    <img src="{{ $comment->user->profile_image ? asset('images/profile/' . $comment->user->profile_image) : asset('images/default-profile.png') }}" alt="Profil" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
                                    <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
