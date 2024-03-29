<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Landing</title>
    </head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <body class="antialiased">
        <div id="app">
        </div>
        <style scoped>
        body {
            background-image: url('/images/management-system.jpg');
        }
        </style>

        <script>
            window.App = {!! json_encode([
                'user' => Auth::user(),
                'signedIn' => Auth::check()
            ]) !!};
    </script>
    </body>
</html>
