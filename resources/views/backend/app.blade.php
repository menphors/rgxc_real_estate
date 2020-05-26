<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--begin::Fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!--end::Fonts -->

    <!--begin::Page Vendors Styles(used by this page) -->
    <link href="{{ asset("backend/vendors/custom/fullcalendar/fullcalendar.bundle.css") }}" rel="stylesheet" type="text/css" />

    <!--end::Page Vendors Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{ asset("backend/vendors/global/vendors.bundle.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("backend/css/demo1/style.bundle.css") }}" rel="stylesheet" type="text/css" />

    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{ asset("backend/css/demo1/skins/header/base/light.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("backend/css/demo1/skins/header/menu/light.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("backend/css/demo1/skins/brand/dark.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("backend/css/demo1/skins/aside/dark.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("backend/css/demo2/pages/wizard/wizard-1.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("backend/css/custom.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("backend/css/simplelightbox.min.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("backend/css/bootstrap-tagsinput.css") }}" rel="stylesheet" type="text/css" />
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Battambang&display=swap" rel="stylesheet">
    @yield('style')
    @php
        $locale = \Illuminate\Support\Facades\App::getLocale();
    @endphp
    <style type="text/css">
       @if($locale == "kh")
            body{
                font-family: 'Battambang'!important;
            }
            h2{
                font-family: 'Battambang'!important;
            }
            h3{
                font-family: 'Battambang'!important;
            }

        @endif

        /*.select2-container--default .select2-selection--single .select2-selection__rendered {
            padding: 1.65rem 1rem 0.65rem 1rem;
        }*/
        .cursor-pointer {
            cursor: pointer;
        }
        .no-padding {
            padding: 0px !important;
        }
        /*select.form-control {
            height: calc(1.1em + 1.3rem + 2px);
        }*/
        .no-margin-bottom {
            margin-bottom: 0px;
        }
        .kt-svg-icon {
            height: 50px;
            width: 50px;
        }
        .kt-portlet.kt-portlet--tabs .kt-portlet__head .kt-portlet__head-toolbar,.kt-portlet .kt-portlet__head .kt-portlet__head-toolbar .nav-pills, .kt-portlet .kt-portlet__head .kt-portlet__head-toolbar .nav-tabs {
            width: 100%;
        }
        .kt-portlet--tabs .nav-tabs.nav-tabs-line .nav-item {
            width: 150px;
        }
        .form-group {
            /*margin-bottom: 0rem;*/
        }
        .hide{
            display: none!important;
        }

        .pagination{
            margin-right: 20px!important;
            float: right!important;
        }

        .label-info{
            background-color: #5bc0de;
            padding-left: 5px;
            padding-right: 5px;
            border-radius: 4px;
        }
        .bootstrap-tagsinput{
            width: 100%!important;
        }
        @media (max-width: 768px) {
          .content { margin-top: 60px; }
        }
    </style>

</head>
<body style="color: black!important;" class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
    <div class="kt-grid kt-grid--hor kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
            @include('backend.partial._left_side_bar')

            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper" style="margin-top: -45px!important;">
                @include('backend.partial._top_nav')
                <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                    @yield('content')
                </div>
                @include('backend.partial._footer')
            </div>
        </div>
    </div>


    <script>
        var KTAppOptions = {
            "colors": {
                "state": {
                    "brand": "#5d78ff",
                    "dark": "#282a3c",
                    "light": "#ffffff",
                    "primary": "#5867dd",
                    "success": "#34bfa3",
                    "info": "#36a3f7",
                    "warning": "#ffb822",
                    "danger": "#fd3995"
                },
                "base": {
                    "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                    "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
                }
            }
        };
    </script>

    <!-- end::Global Config -->

    <!--begin::Global Theme Bundle(used by all pages) -->
    <script src="{{ asset("backend/vendors/global/vendors.bundle.js") }}" type="text/javascript"></script>
    <script src="{{ asset("backend/js/demo1/scripts.bundle.js") }}" type="text/javascript"></script>

    <!--end::Global Theme Bundle -->

    <!--begin::Page Vendors(used by this page) -->
    <script src="{{  asset("backend/vendors/custom/fullcalendar/fullcalendar.bundle.js") }}" type="text/javascript"></script>
    <!-- <script src="//maps.google.com/maps/api/js?key=AIzaSyDz1brUV7gJ35opKvQ9ls0n08a14eOXZP8" type="text/javascript"></script> -->

    <!--begin::Page Scripts(used by this page) -->
    <script src="{{ asset("backend/js/demo1/pages/dashboard.js") }}" type="text/javascript"></script>
    <script src="{{ asset("backend/js/simple-lightbox.js") }}" type="text/javascript"></script>
    <script src="{{ asset("backend/js/bootstrap-tagsinput.js") }}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.4/tinymce.min.js" type="text/javascript"></script>
    @include('backend.partial.delete-modal')
    @yield('script')
    @include('backend.partial.custom_script')
</body>
</html>
