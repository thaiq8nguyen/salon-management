<!doctype html>
<html>
    <head>
        <title>@yield('title')</title>
        {{--<link rel = "stylesheet" href = "{{ asset('css/bootstrap.css') }}">--}}
        <link rel = "stylesheet" href = "{{ asset('css/font-awesome.css') }}">
        <link rel = "stylesheet" href = "{{ asset('css/pdf-payment.css') }}">
        <link rel = "shortcut icon" type = "image/png" href = "{{ asset('favicon.png') }}">
        <style>
            body{
                font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            }
        </style>
    </head>
    <body>

        <div class = "main-content">
            @yield('content')
        </div>
    </body>
</html>