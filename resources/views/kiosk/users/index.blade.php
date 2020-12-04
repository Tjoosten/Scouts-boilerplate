<x-app-kiosk-layout :title="__('Gebruikers')">
    <div class="container-fluid py-3">
        <div class="page-header">
            <h1 class="page-title color-bruin">{{ __('Gebruikers') }}</h1>
            <div class="page-subtitle">{{ __('Overzicht van alle gebruikers in :application', ['application' => config('app.name')]) }}</div>

            <div class="page-options d-flex">
                <a href="" class="btn btn-primary border-0 shadow-sm">
                    <x-heroicon-o-user-add class="icon"/>
                </a>

                <div class="btn-group mx-2">
                    <button type="button" class="btn btn-primary border-0 shadow-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <x:heroicon-o-filter class="icon mr-1"/> {{ __('Filter') }}
                    </button>
                    <div class="dropdown-menu border-0 shadow-sm">
                        <a class="dropdown-item" href="{{ route('kiosk.users.index') }}">{{ __('Alle gebruikers') }}</a>
                        <a class="dropdown-item" href="">{{ __('Geactiveerde gebruikers') }}</a>
                        <a class="dropdown-item" href="">{{ __('Gedeactiveerde gebruikers') }}</a>
                    </div>
                </div>

                <form method="GET" action="" class="form-inline">
                    <input type="text" name="term" value="{{ request('term') }}" class="form-control form-search border-0 shadow-sm" placeholder="{{ __('Zoek bij naam of email adres') }}">
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid pb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
            </div>
        </div>
    </div>
</x-app-kiosk-layout>
