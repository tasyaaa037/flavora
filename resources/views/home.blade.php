@extends('layouts.app')

@section('title', 'Delfood - Home')

@section('content')
    <!-- Slider -->
    @include('partials.slider')

    <!-- Search Bar -->
    @include('partials.search')

    <!-- Popular Recipes -->
    <section class="popular-recipes py-5">
        <div class="container">
            <h2 class="text-center mb-4">Popular Recipes</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ asset('template/images/breakfast.jpg') }}" class="card-img-top" alt="Breakfast">
                        <div class="card-body">
                            <h5 class="card-title">Breakfast</h5>
                            <p class="card-text">Start your day with our delicious breakfast options.</p>
                            <a href="#" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ asset('template/images/lunch.jpg') }}" class="card-img-top" alt="Lunch">
                        <div class="card-body">
                            <h5 class="card-title">Lunch</h5>
                            <p class="card-text">Satisfy your hunger with our amazing lunch dishes.</p>
                            <a href="#" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ asset('template/images/dinner.jpg') }}" class="card-img-top" alt="Dinner">
                        <div class="card-body">
                            <h5 class="card-title">Dinner</h5>
                            <p class="card-text">Finish your day with a tasty dinner from our menu.</p>
                            <a href="#" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News -->
    <section class="latest-news py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Latest News</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <img src="{{ asset('template/images/news1.jpg') }}" class="card-img-top" alt="News 1">
                        <div class="card-body">
                            <h5 class="card-title">New Restaurant Opens</h5>
                            <p class="card-text">Discover our new restaurant in your area.</p>
                            <a href="#" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <img src="{{ asset('template/images/news2.jpg') }}" class="card-img-top" alt="News 2">
                        <div class="card-body">
                            <h5 class="card-title">New Recipe Added</h5>
                            <p class="card-text">Try our latest recipe added to the menu.</p>
                            <a href="#" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
