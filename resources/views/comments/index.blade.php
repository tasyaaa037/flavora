@extends('layouts.profile')

@section('content')
<div class="flex flex-col lg:flex-row items-center lg:items-start lg:justify-between lg:space-x-6 mt-8 mb-8">
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
            <button class="mt-4 bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-lg shadow-sm flex items-center" 
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt mr-2"></i> Log out
            </button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <!-- Saved Items Section -->
    <div class="bg-white p-6 rounded-lg shadow-md w-full lg:w-2/3 border-4 border-blue-800">
        <div class="flex justify-between items-center mb-4">
            <div class="text-sm text-gray-500">
                <a href="{{ route('profile.show') }}" class="text-orange-500 hover:underline">Profil</a> &gt; Aktivitas
            </div>
        </div>
        <h1 class="text-2xl font-bold mb-4">Tersimpan</h1>
        <p class="text-gray-500">Belum ada yang tersimpan. Tap <i class="far fa-bookmark"></i> untuk menyimpan resep dan promo pertama Anda.</p>
    </div>
</div>
@endsection
