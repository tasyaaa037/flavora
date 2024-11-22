<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Flavora')</title>
    
    <!-- Fonts and Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('delfood-1.0.0/css/style1.css') }}">
    <link rel="stylesheet" href="{{ asset('delfood-1.0.0/css/responsive.css') }}" />

    <!-- Custom Stylesheets for specific libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" crossorigin="anonymous" />
    
    <!-- Font Awesome, loaded last to ensure icon display -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    @stack('styles')
    <!-- Scoped Tailwind Styles -->

</head>
<body>
    <!-- Include header -->
    @include('partials.headersubcategories')
    
      <!-- Main Content -->
    <div class="container">
        @yield('content')
    </div>
    
    <!-- Include footer -->
    @include('partials.footer')

    <!-- Scripts -->
    <script src="{{ asset('delfood-1.0.0/js/jquery-3.4.1.min.js') }}" defer></script>
    <script src="{{ asset('delfood-1.0.0/js/bootstrap.js') }}" defer></script>
    <script src="{{ asset('delfood-1.0.0/js/custom.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
