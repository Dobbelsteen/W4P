<!DOCTYPE html>
<html @yield('html')>
    <head>
        <meta charset="utf-8">
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- Elixir is responsible for the versioned css so you'll need npm :) --}}
        <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
        {{-- Google Web Fonts are inserted here --}}
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
        {{-- Check if the meta section exists --}}
        @if (array_key_exists('meta', View::getSections()))
            {{-- If the meta section exists, it is rendered here --}}
            @yield('meta')
        @else
            {{-- Otherwise, use the default meta partial --}}
            @include('partials.meta.default')
        @endif
    </head>
    <body>
        @include('partials.ga')
        {{-- WRAPPER --}}
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    {{-- NAVIGATION --}}
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#hamburger" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" href="{{ URL::route('home') }}">
                                    <img src="{{ URL::to('/platform/logo.png') }}" class="navlogo" />
                                </a>
                            </div>
                            <div class="collapse navbar-collapse" id="hamburger">
                                <ul class="nav navbar-nav">
                                    <li @if (Request::is('/')) class="active" @endif>
                                        <a href="{{ URL::route('home') }}">{{ $W4P_project->title }}</a>
                                    </li>
                                    <li @if (Request::is('how-it-works')) class="active" @endif>
                                        <a href="{{ URL::route('how') }}">{{ trans('generic.how_does_it_work') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            {{-- MAIN CONTENT --}}
            <div class="content">
                @yield('content')
            </div>
        </div>
        @include('partials.footer')
    </body>
    <script src="{{ elixir("js/core.js") }}"></script>
    @yield('scripts')
</html>