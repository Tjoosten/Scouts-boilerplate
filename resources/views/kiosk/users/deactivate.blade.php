<x-app-kiosk-layout :title="__('Deactiveer gebruiker')">
    <div class="container-fluid py-3">
        <div class="page-header">
            <h1 class="page-title text-bruin">{{ __('Gebruikers') }}</h1>
            <div class="page-subtitle">{{ __('Deactivatie account van :user in :application', ['user' => $user->name, 'application' => config('app.name')]) }}</div>

            <div class="page-options d-flex">
                <a href="{{ route('kiosk.users.index') }}" class="btn btn-primary border-0 shadow-sm">
                    <x-heroicon-o-users class="icon mr-1"/> {{ __('Gebruikers overzicht') }}
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
                <x-form method="POST" class="card border-0 shadow-sm" :action="route('kiosk.users.deactivate', $user)">
                    <div class="card-body">
                        <h6 class="border-bottom border-gray pb-1 mb-3">{{ __('Deactivatie account van :user in :application', ['user' => $user->name, 'application' => config('app.name')]) }}</h6>

                        <p class="card-text text-danger">
                            <x:heroicon-o-exclamation class="icon mr-1"/> {{ __('Bij het deactiveren van :user zal hij/zij niet meer kunnen inloggen op :application', ['user' => $user->name, 'application' => config('app.name')]) }}
                        </p>

                        <p class="card-text">
                            {{ __('Bij het deactiveren van :user vragen we je een reden op te geven voor de activatie.', ['user' => $user->name]) }} <br>
                            {{ __('Zodat we :user en andere applicatie beheerders op de hoogte kunnen stellen van de deactivatie', ['user' => $user->name]) }}
                        </p>

                        <hr>

                        <div class="form-row">
                            <div class="form-group col-12 mb-0">
                                <label for="reason">{{ __('Deactivatie redenen') }}</label>
                                <textarea placeholder="{{ __('Beschrijf kort de reden voor de deactivatie') }}" id="reason" rows="4" class="form-control @error('reden') is-invalid @enderror" name="reden">{{ old('reden') }}</textarea>
                                <x-error class="invalid-feedback" field="reden"/>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-top-0">
                        <div class="float-right">
                            <a href="{{ route('kiosk.users.show', $user) }}" class="btn btn-link text-decoration-none border-0">
                                {{ __('Annuleren') }}
                            </a>
                            <button type="submit" class="btn btn-danger border-0 shadow-sm">
                                {{ __('Deactiveren') }}
                            </button>
                        </div>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
</x-app-kiosk-layout>
