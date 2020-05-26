<html>
    <head>

        <!--begin::Base Path (base relative path for assets of this page) -->
        <base href="../../../../">

        <!--end::Base Path -->
        <meta charset="utf-8" />
        <title>RXGC | Login</title>
        <meta name="description" content="Login page example">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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

        <!--begin::Page Custom Styles(used by this page) -->
        <link href="{{ asset("backend/css/demo1/pages/login/login-1.css") }}" rel="stylesheet" type="text/css" />

        <!--end::Page Custom Styles -->

        <!--begin::Global Theme Styles(used by all pages) -->
        <link href="{{ asset("backend/vendors/global/vendors.bundle.css") }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("backend/css/demo1/style.bundle.css") }}" rel="stylesheet" type="text/css" />

        <!--end::Global Theme Styles -->

        <!--begin::Layout Skins(used by all pages) -->
        <link href="{{ asset("backend/css/demo1/skins/header/base/light.css") }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("backend/css/demo1/skins/header/menu/light.css") }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("backend/css/demo1/skins/brand/dark.css") }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("backend/css/demo1/skins/aside/dark.css") }}" rel="stylesheet" type="text/css" />
    </head>

    <body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
        @yield('content')
        <!-- begin::Global Config(global config for global JS sciprts) -->
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


        @yield('script')
    </body>
</html>