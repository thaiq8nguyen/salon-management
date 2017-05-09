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
    <script src = "{{ asset('js/jquery.js') }}"></script>
    <script src = "{{ asset('js/moment.min.js') }}"></script>
    @stack('scripts')
</html>