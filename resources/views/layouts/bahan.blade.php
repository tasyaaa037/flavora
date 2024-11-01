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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .sidebar ul li input[type="checkbox"] {
            margin-left: auto;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .content .tags {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .content .tags span {
            background-color: #f0f0f0;
            padding: 5px 10px;
            border-radius: 20px;
            margin-right: 10px;
            display: flex;
            align-items: center;
        }
        .content .tags span i {
            margin-left: 5px;
            cursor: pointer;
        }
        .content .tags .clear {
            color: #007bff;
            cursor: pointer;
        }
        .content .recipes {
            display: flex;
            flex-wrap: wrap;
            gap: 15px; /* Reduced gap */
        }
        .content .recipe-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: calc(30% - 15px); /* Adjusted width */
            max-width: 250px; /* Optional: set a maximum width */
            padding: 10px; /* Reduced padding */
            box-sizing: border-box;
        }
        .content .recipe-card img {
            width: 100%;
            border-radius: 10px;
        }
        .content .recipe-card .author {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .content .recipe-card .author img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .content .recipe-card .author .name {
            font-weight: bold;
        }
        .content .recipe-card .author .verified {
            color: #007bff;
            margin-left: 5px;
        }
        .content .recipe-card .title {
            margin-top: 10px;
            font-weight: bold;
        }
        .bg-orange-100 {
            background-color: #fce8b2;
        }
        .text-orange-600 {
            color: #b86a2d;
        }
        /* Custom Styling */
        .hidden {
            display: none;
        }
        .dropdown-menu {
            min-width: 150px;
        }
        .dropdown-item {
            font-size: 14px;
            padding: 8px 12px;
        }
</style>
</head>
<body>
    <!-- Include header -->
    @include('partials.headersubcategories')
    
    <!-- Main Content wrapped in Tailwind scope -->
    <div class="container tailwind-content">
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
