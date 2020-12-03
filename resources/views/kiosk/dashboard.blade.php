<x-app-kiosk-layout :title="__('Kiosk dashboard')">
    <div class="container-fluid py-3">
        <div class="page-header">
            <h1 class="page-title text-bruin">{{ __('Dashboard') }}</h1>
        </div>
    </div>

    <div class="container-fluid pb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-bottom-0">
                {{ __('Administratie kiosk dashboard') }}
            </div>
            <div class="card-body">
                {{ __('U bevind zich nu in de administratieve kiosk. Het hart waar u alles omtrent uw applicatie kunt regelen.') }}
                {{ __('Van gebruikers de logs, etc. bijvoorbeeld.') }}
            </div>
        </div>
    </div>
</x-app-kiosk-layout>
