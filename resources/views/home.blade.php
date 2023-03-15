<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Home page</title>
    </head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <body class="antialiased">
        <!-- <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
        </form> -->
        <div id="app">
        </div>
    </body>
</html>
