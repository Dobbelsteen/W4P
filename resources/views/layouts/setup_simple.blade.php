<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
        <link href='https://fonts.googleapis.com/css?family=Istok+Web:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
    </head>
    <body class="setup">
        <div class="setup progress-wrapper">
            <div class="container">
                <div class="logo">
                    <img src="{{ URL::to('assets/logo/logo_w4p.png') }}" width="130" />
                </div>
            </div>
        </div>
        <div class="setup content-wrapper">
            <div class="container">
                @yield('content')
            </div>
        </div>
    </body>
    <script src="{{ elixir("js/core.js") }}"></script>
    <script src="{{ elixir("js/admin.js") }}"></script>
</html>