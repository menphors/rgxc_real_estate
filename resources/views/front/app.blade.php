<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name') }} | @yield('title')</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <link rel="shortcut icon" type="image/png" href="{{ (isset($config->data->fav) && $config->data->fav!='') ? asset(config('global.config_path').$config->data->fav) : asset('images/favicon.png') }}">

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
  <!-- Styles -->
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.css') }}">

  <link href="https://fonts.googleapis.com/css?family=Battambang&display=swap" rel="stylesheet">
  <!-- Main stylesheet  -->
  @php
    $locale = \Illuminate\Support\Facades\App::getLocale();
  @endphp

  <style type="text/css">
    @if($locale == "kh")
      body, h2, h3 { font-family: 'Battambang'!important; }
    @endif
  </style>
  @yield('style')
</head>
<body>
  <div id="preloader"></div>

  @include('front.partial._top_nav')

  @yield('content')

  @include('front.partial._brand_carousel')
  @include('front.partial._footer')
  <!-- jQuery -->
  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

  <!-- Bootstrap -->
  <script src="{{ asset('assets/js/bootstrap.js') }}"></script>

  <!-- carousel -->
  <script src="{{ asset('assets/js/owl.carousel.js') }}"></script>

  <!-- carousel -->
  <script src="{{ asset('assets/js/slider.js') }}"></script>

  <!-- wow -->
  <script src="{{ asset('assets/js/wow.min.js') }}"></script>

  <!-- custom -->
  <script src="{{ asset('assets/js/custom.js') }}"></script>
  @stack('js')
  @yield('script')
</body>
</html>
