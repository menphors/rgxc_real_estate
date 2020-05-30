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

  <link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet">

  <!-- Needed CSS -->
  <link rel="stylesheet" type="text/css" href="{{ asset("css/font-awesome.min.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/icofont.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/bootstrap-dropdownhover.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/featherlight.min.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/featherlight.gallery.min.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/hover.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/flexslider.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/owl.carousel.min.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/owl.theme.default.min.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/slick.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/slick-theme.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/jquery-ui.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/animations.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/animate.min.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/morphext.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/owl.carousel.min.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/owl.theme.default.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/jquery.mb.YTPlayer.min.css") }}">

  <link href="https://fonts.googleapis.com/css?family=Battambang&display=swap" rel="stylesheet">
  <!-- Main stylesheet  -->
  <link rel="stylesheet" type="text/css" href="{{ asset("css/style.css") }}">
  <!-- Responsive stylesheet  -->
  <link rel="stylesheet" type="text/css" href="{{ asset("css/responsive.css") }}">
  <link href="{{ asset("backend/css/simplelightbox.min.css") }}" rel="stylesheet" type="text/css" />
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
  <script src="{{ asset("js/jquery.min.js") }}"></script>
  <!-- Bootstrap Core JavaScript -->
  <script src="{{ asset("js/bootstrap.min.js") }}"></script>

  <!-- all plugins and JavaScript -->
  <script type="text/javascript" src="{{ asset("js/css3-animate-it.js") }}"></script>
  <script type="text/javascript" src="{{ asset("js/bootstrap-dropdownhover.min.js") }}"></script>
  <script type="text/javascript" src="{{ asset("js/featherlight.min.js") }}"></script>
  <script type="text/javascript" src="{{ asset("js/featherlight.gallery.min.js") }}"></script>
  <script type="text/javascript" src="{{ asset("js/jquery.flexslider.js") }}"></script>
  <script type="text/javascript" src="{{ asset("js/owl.carousel.min.js") }}"></script>
  <script type="text/javascript" src="{{ asset("js/jarallax.js") }}"></script>
  <script type="text/javascript" src="{{ asset("js/slick.min.js") }}"></script>
  <script type="text/javascript" src="{{ asset("js/jquery-ui.js") }}"></script>
  <script type="text/javascript" src="{{ asset("js/jquery-scrolltofixed-min.js") }}"></script>
  <script type="text/javascript" src="{{ asset("js/morphext.min.js") }}"></script>
  <script type="text/javascript" src="{{ asset("js/dyscrollup.js") }}"></script>
  <script type="text/javascript" src="{{ asset("js/jquery.ripples.js") }}"></script>
  <script type="text/javascript" src="{{ asset("js/jquery.mb.YTPlayer.min.js") }}"></script>
  <script type="text/javascript" src="{{ asset("js/app.js") }}"></script>

  <!-- Main Custom JS -->
  <script type="text/javascript" src="{{ asset("js/main.js") }}"></script>
  <script src="{{ asset("backend/js/simple-lightbox.js") }}" type="text/javascript"></script>
  @stack('js')
  @yield('script')
</body>
</html>
