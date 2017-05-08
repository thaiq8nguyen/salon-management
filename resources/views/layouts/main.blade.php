<!doctype html>
<html>
    <head>
        <title>@yield('pageTitle')</title>
        <!--Common Stylesheets-->
        <link rel = "stylesheet" href = "{{ asset('css/bootstrap.css') }}">
        <!--Specific Stylesheets-->
        @stack('styles')
    </head>
    <body>
        @yield('nav-bar')
        @yield('content')
    </body>

<!--JavaScript-->
    <!--Common Scripts-->
    <script src = "{{ asset('js/vue.js') }}"></script>
    @stack('scripts')
</html>