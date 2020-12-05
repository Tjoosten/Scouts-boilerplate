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
        <nav class="navbar navbar-expand-lg navbar-dark bg-bruin">
            <img src="{{ asset('img/logo.png') }}" width="35" height="35" class="mr-3 rounded-circle d-inline-block align-top" alt="{{ config('app.name', 'Laravel') }}">
            <a class="navbar-brand mr-auto mr-lg-0" href="#">
                {{ config('app.name', 'Laravel') }}
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                @auth
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <x-heroicon-o-user class="mr-1 icon text-lichtgroen"/> {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right border-0 shadow-sm" aria-labelledby="accountDropdown">
                                <a class="dropdown-item" href="{{ route('welcome') }}">
                                    <x-heroicon-o-globe class="icon text-bruin mr-1"/> {{ __('Website') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('account.settings') }}">
                                    <x-heroicon-o-adjustments class="color-bruin icon mr-1"/> {{ __('Instellingen') }}
                                </a>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <x-heroicon-o-logout class="text-danger icon mr-1"/> {{ __('Afmelden') }}

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf {{-- Form field protection --}}
                                    </form>
                                </a>
                            </div>
                        </li>
                    </ul>
                @endif
            </div>
        </nav>
        <div class="nav-scroller bg-lichtgroen shadow-sm">
            <nav class="nav nav-underline">
                <a href="{{ route('kiosk.dashboard') }}" class="{{ active('kiosk.dashboard') }} nav-link">
                    <x:heroicon-o-home class="icon mr-1"/> {{ __('Dashboard') }}
                </a>

                <a href="{{ route('kiosk.users.index') }}" class="nav-link {{ active('kiosk.users.*') }}">
                    <x:heroicon-o-users class="icon mr-1"/> {{ __('Gebruikers') }}
                </a>
            </nav>
        </div>

        <x-app-flash-message/>

        <main role="main">
            {{ $slot }}
        </main>

        <footer class="footer">
            <div class="container-fluid">
                <span class="text-muted font-weight-bold">&copy; 2019 - {{ date('Y') }} <span class="ml-1">{{ config('app.name') }}</span></span>
            </div>
        </footer>
    </div>
</body>
</html>
