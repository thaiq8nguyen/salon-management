<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Salon Management</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <div id="app">
            <router-view></router-view>
        </div>
        <script src={{asset('js/app.js')}}></script>
    </body>
</html>