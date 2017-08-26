<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSRF Token -->
        <meta name="csrf-token" content = "{{ csrf_token() }}">
        <title>@yield('pageTitle')</title>
        <!--Common Stylesheets-->
        <link rel = "shortcut icon" type = "image/png" href = "{{ asset('favicon.png') }}">
        <link rel = "stylesheet" href = "{{ asset('css/bootstrap.css') }}">
        <link rel = "stylesheet" href = "{{ asset('css/font-awesome.css') }}">
        <link rel = "stylesheet" href = "{{ asset('css/custom.css') }}">
        <link rel = "stylesheet" href = "{{ asset('css/main-navbar.css')}}">
        <!--Common Fonts-->
        <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet" type="text/css">
        <!--Specific Stylesheets-->
        @stack('styles')

    </head>
    <body>
        @yield('content')
    </body>
    <!--JavaScript-->
    <!--Common Scripts-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    @stack('scripts')
</html>