<!-- resources/views/profile/show.blade.php -->
@extends('layouts.profile')

@section('content')
    <div class="container mx-auto p-6">
        <div class="heading_container heading_center mb-4">
            <h2>Profil Pengguna</h2>
        </div>
        <div class="flex flex-col lg:flex-row items-center lg:items-start lg:justify-between lg:space-x-6">
            <!-- User Info Section -->
            <div class="flex flex-col items-center bg-white p-6 rounded-lg shadow-md w-full lg:w-1/3 border-4 border-blue-800">
                <div class="flex flex-col items-center">
                    <div class="bg-gray-700 text-white rounded-full h-24 w-24 flex items-center justify-center text-4xl">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-gray-500">Halo,</p>
                        <p class="text-xl font-semibold">{{ $user->name }}</p>
                    </div>
                    <button class="mt-4 bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-lg shadow-sm flex items-center" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt mr-2"></i> Log out
                    </button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Saved Recipes and Discussions Section -->
            <div class="flex flex-col w-full lg:w-2/3 space-y-6">
                <!-- Saved Section -->
                <div class="bg-white p-6 rounded-lg shadow-md border-4 border-blue-800">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-bookmark text-gray-500 mr-2"></i>
                            <p class="text-gray-700 font-semibold">Tersimpan</p>
                        </div>
                        <a href="{{ route('favorite.recipes') }}" class="text-teal-500">Lihat semua</a>
                    </div>
                    <p class="text-gray-500">Belum ada yang tersimpan. Tap <i class="fas fa-bookmark"></i> untuk menyimpan resep.</p>
                </div>

                <!-- Testimonials/Discussions Section -->
                <div class="bg-white p-6 rounded-lg shadow-md border-4 border-blue-800">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-comments text-gray-500 mr-2"></i>
                            <p class="text-gray-700 font-semibold">Testi / Diskusi</p>
                        </div>
                        <a href="{{ route('user.comments') }}" class="text-teal-500">Lihat semua</a>
                    </div>
                    <p class="text-gray-500">Belum ada aktifitas Testi / Diskusi kamu.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
