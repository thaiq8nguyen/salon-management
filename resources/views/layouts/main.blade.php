<!doctype html>
<html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('pageTitle')</title>
        <!--Common Stylesheets-->
        <link rel = "stylesheet" href = "{{ asset('css/bootstrap.css') }}">
        <link rel = "stylesheet" href = "{{ asset('css/custom.css') }}">
        <!--Specific Stylesheets-->
        @stack('styles')
    </head>
    <body>
        @include('partials.main-navbar')
        @yield('content')
    </body>
<!--JavaScript-->
    <!--Common Scripts-->
    <script src = "{{ asset('js/jquery.js') }}"></script>
    <script src = "{{ asset('js/moment.min.js') }}"></script>
    @stack('scripts')
</html>