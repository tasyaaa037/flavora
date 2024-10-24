@extends('layouts.resep')
@section('title', 'Flavora - All Resep!')
@section('content')
<div class="container">
    <div class="heading_container heading_center mb-5">
        <h2 style="font-weight: normal; letter-spacing: 1px; color: #333; margin-top: 20px;">Semua Resep</h2>
    </div>
    <div class="row">
        @foreach ($recipes as $recipe)
        <div class="col-md-3 mb-4">
            <a href="{{ route('recipes.show', $recipe->id) }}">
                <div class="card shadow-sm rounded-lg" style="border: none;">
                    <img src="{{ asset('delfood-1.0.0/images/' . $recipe->image) }}"
                         alt="{{ $recipe->title }}"
                         class="card-img-top"
                         style="height: 200px; object-fit: cover; border-radius: 10px;">
                </div>
            </a>
            <div class="mt-2">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="mb-1" style="font-size: 16px; font-weight: bold; color: #333;">{{ $recipe->title }}</h5>
                        <p class="text-muted" style="font-size: 14px;">
                            <i class="fa fa-clock-o"></i> {{ $recipe->prep_time }} menit
                        </p>
                    </div>
                </div>
                <!-- Pindahkan tombol ke sebelah kanan -->
                <div class="d-flex justify-content-end mt-2">
                    <button class="btn favorite-button" data-recipe-id="{{ $recipe->id }}">
                        <i class="fa fa-bookmark-o"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal Login -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login Diperlukan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Anda harus login untuk menyimpan resep. Apakah Anda ingin login sekarang?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button id="goToLogin" type="button" class="btn btn-primary">Login</button>
            </div>
        </div>
    </div>
</div>

<!-- Script AJAX untuk handle Favorite -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.favorite-button').forEach(function (button) {
        button.addEventListener('click', function () {
            const recipeId = this.getAttribute('data-recipe-id');
            
            fetch('/check-auth', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(authData => {
                if (!authData.authenticated) {
                    sessionStorage.setItem('redirectAfterLogin', window.location.href);
                    var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                    loginModal.show();
                } else {
                    fetch(`/favorites/${recipeId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            button.innerHTML = '<i class="fa fa-bookmark"></i> Favorited';
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    document.getElementById('goToLogin').addEventListener('click', function() {
        var currentUrl = sessionStorage.getItem('redirectAfterLogin') || window.location.href;
        window.location.href = "{{ route('login') }}" + "?redirect=" + encodeURIComponent(currentUrl);
    });
});

</script>

@endsection
