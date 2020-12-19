<x-app-layout :title="__('Account instellingen')">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title text-donkergroen">{{ $user->name }}</h1>
            <div class="page-subtitle">{{ __('account instellingen') }}</div>
        </div>
    </div>

    <div class="container pt-3">
        <div class="row">
            @include ('auth.settings._settings-nav')
        </div>

        <div class="row">
            <div class="col-3">
                <h5 class="text-bijna-zwart font-weight-bold">{{ __('Account beveiliging') }}</h5>
                <p class="small text-muted">{{ __('Gebruik bij het wijzigen van je wachtwoord een lang en robust wachtwoord.') }}</p>
            </div>

            <div class="offset-1 col-8">
                <x-form method="PATCH" class="card border-0 shadow-sm" :action="route('account.settings.security')">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="currentPassword" class="col-sm-4 col-form-label">{{ __('Huidig wachtwoord') }}</label>
                            <div class="col-sm-8">
                                <input type="password" name="currentPassword" class="form-control @error('currentPassword') is-invalid @enderror" id="currentPassword" placeholder="{{ __('huidig wachtwoord') }}">
                                <x-error class="invalid-feedback" field="currentPassword"/>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label for="newPassword" class="col-sm-4 col-form-label">{{ __('Nieuw wachtwoord') }}</label>
                            <div class="col-sm-4">
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="newPassword" placeholder="{{ __('nieuw wachtwoord') }}">
                                <x-error class="invalid-feedback" field="password"/>
                            </div>
                            <div class="col-sm-4">
                                <input type="password" name="password_confirmation" class="form-control" id="newPassword" placeholder="{{ __('wachtwoord confirmatie') }}">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer border-top-0">
                        <div class="row">
                            @if (session('securityUpdated'))
                                <div class="col my-auto text-success font-weight-bold">
                                    <x-heroicon-o-check-circle class="icon"/> {{ __('Account beveiliging aangepast.') }}
                                </div>
                            @endif

                            <div class="col text-secondary text-right my-auto">
                                <button type="submit" class="btn btn-primary border-0">{{ __('Opslaan') }}</button>
                            </div>
                        </div>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
</x-app-layout>
