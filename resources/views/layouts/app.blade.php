<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Flavora</title>


  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="delfood-1.0.0/css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">

  <!-- font awesome style -->
  <link href="delfood-1.0.0/css/font-awesome.min.css" rel="stylesheet" />
  <!-- nice select -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha256-mLBIhmBvigTFWPSCtvdu6a76T+3Xyt+K571hupeFLg4=" crossorigin="anonymous" />
  <!-- slidck slider -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha256-UK1EiopXIL+KVhfbFa8xrmAWPeBjMVdvYMYkTAEv/HI=" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css.map" integrity="undefined" crossorigin="anonymous" />


  <!-- Custom styles for this template -->
  <link href="delfood-1.0.0/css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="delfood-1.0.0/css/responsive.css" rel="stylesheet" />
    <style>
    .dropdown-menu {
      min-width: 150px; /* Mengubah lebar dropdown */
    }

    .dropdown-item {
      font-size: 14px; /* Mengubah ukuran font item */
      padding: 8px 12px; /* Mengubah padding item */
    }
  </style>
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

    <!-- jQery -->
    <script src="delfood-1.0.0/js/jquery-3.4.1.min.js"></script>
    <!-- bootstrap js -->
    <script src="delfood-1.0.0/js/bootstrap.js"></script>
    <!-- slick  slider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>
    <!-- nice select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" integrity="sha256-Zr3vByTlMGQhvMfgkQ5BtWRSKBGa2QlspKYJnkjZTmo=" crossorigin="anonymous"></script>
    <!-- custom js -->
    <script src="delfood-1.0.0/js/custom.js"></script>
</body>
</html>