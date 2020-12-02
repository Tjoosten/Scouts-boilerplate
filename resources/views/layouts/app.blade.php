<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | {{ $title }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-dark bg-bruin shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <img src="{{ asset('img/logo.png') }}" width="25" height="25" class="mr-2 rounded-circle my-auto" alt="{{ config('app.name', 'Laravel') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    @auth
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link {{ active('home') }}">
                                {{ __('Home') }}
                            </a>
                        </li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link {{ active('login') }} "href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link {{ active('register') }}" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <x-heroicon-o-user class="icon mr-1"/> {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu border-0 shadow-sm dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if (Auth::user()->canAccessKiosk())
                                    <a href="" class="dropdown-item">
                                        <x-heroicon-o-home class="icon mr-1 color-bruin"/> {{ __('Kiosk') }}
                                    </a>
                                @elseif(Auth::user()->isOnKiosk())
                                    <a href="{{ route('welcome') }}" class="dropdown-item">
                                        <x-heroicon-o-globe class="icon mr-1 color-bruin"/> {{ __('Website') }}
                                    </a>
                                @endif

                                <a href="{{ route('account.settings') }}" class="dropdown-item">
                                    <x-heroicon-o-adjustments class="color-bruin icon mr-1"/> {{ __('Instellingen') }}
                                </a>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <x-heroicon-o-logout class="text-danger icon mr-1"/> {{ __('Afmelden') }}

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </a>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        {{ $slot }}
    </main>
</div>
</body>
</html>
