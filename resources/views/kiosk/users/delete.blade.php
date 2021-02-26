<x-app-kiosk-layout :title="__('Verwijder gebruiker')">
    <div class="container-fluid py-3">
        <div class="page-header">
            <h1 class="page-title text-bruin">{{ __('Gebruikers') }}</h1>
            <div class="page-subtitle">{{ __('Account verwijdering van :user', ['user' => $user->name]) }}</div>

            <div class="page-options d-flex">
                <a href="{{ route('kiosk.users.index') }}" class="btn btn-primary border-0 shadow-sm">
                    <x-heroicon-o-users class="icon mr-1"/> {{ __('Gebruikers verzicht') }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid pb-3">
        <div class="row">
            <div class="col-3">
                <x-user-side-navigation :user="$user"/>
            </div>
            <div class="col-9">
                <x-form method="DELETE" :action="route('kiosk.users.delete', $user)" class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="border-bottom border-gray pb-1 mb-3">{{ __('Account verwijdering van :user', ['user' => $user->name]) }}</h6>

                        <p class="card-text text-danger mb-3">
                            <x-heroicon-o-exclamation class="icon mr-1"/>
                            {{ __('U staat op het punt een de gebruikersaccount van :user te verwijderen.', ['user' => $user->name]) }}
                        </p>

                        <p class="card-text">
                            {{ __('Bij het verwijderen van je account. Zal al je data permanent verwijderd worden. Als ook zal de verwijdering niet ongedaan gemaakt kunnen worden, vandaar dat je we willen vragen om zeker te zijn over het verwijderen van je account.') }}
                        </p>
                    </div>
                    <div class="card-footer border-top-0">
                        <a href="{{ route('kiosk.users.index') }}" class="btn btn-light border-0">
                            {{ __('Annuleren') }}
                        </a>

                        <button type="submit" class="btn btn-danger border-0 shadow-sm">
                            <x-heroicon-o-trash class="icon mr-1"/> Account verwijderen
                        </button>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
</x-app-kiosk-layout>
