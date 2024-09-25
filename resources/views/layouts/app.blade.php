<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Delfood')</title>
    
    <!-- Fonts and Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/template/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('template/css/style.css') }}">
    
    @stack('styles')
</head>
<body>
    <!-- Include header -->
    @include('partials.header')

    <!-- Main Content -->
    <div class="container">
        @yield('content')
    </div>

    <!-- Include footer -->
    @include('partials.footer')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/template/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template/js/script.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
