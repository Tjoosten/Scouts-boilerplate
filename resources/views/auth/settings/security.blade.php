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

        @if ($authSessions->count() > 0)
            <hr class="my-4">

            <div class="row">
                <div class="col-3">
                    <h5 class="text-bijna-zwart font-weight-bold">{{ __('Aangemelde apparaten') }}</h5>
                    <p class="small text-muted">{{ __('Beheer en logout uw active sessies op andere browsers en apparaten.') }}</p>
                </div>

                <div class="offset-1 col-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            @if ($errors->has('password-confirmation'))
                                <p class="card-text text-danger font-weight-bold"><x-heroicon-o-shield-exclamation class="icon"/>{{ $errors->first('password-confirmation') }}</p>
                            @endif

                            <p class="card-text">
                                {{ __('Indien nodig kunt u op al uw apparaten uitloggen bij al uw andere browsersessies.') }}
                                {{ __('Enkele van uw recente sessies staan hieronder vermeld, deze lijst is echter mogelijk niet volledig.') }}
                                {{ __('Als u denkt dat uw account is gehackt, raden we u ook aan om je wachtwoord bij te werken.') }}
                            </p>
                        </div>
                        <div class="list-group list-group-flush">
                            @foreach ($authSessions as $authSession)
                                <div class="list-group-item border-0">
                                    <div class="media">
                                        @if ($authSession->agent->isDesktop())
                                            <x-heroicon-o-desktop-computer class="mr-3 icon text-muted icon-lg"/>
                                        @elseif ($authSession->agent->isTablet())
                                            <x-heroicon-o-device-tablet class="mr-3 icon text-muted icon-lg"/>
                                        @else
                                            <x-heroicon-o-device-mobile class="mr-3 icon text-muted icon-lg"/>
                                        @endif

                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1 text-gray-600">
                                                {{ $authSession->agent->platform() }} - {{ $authSession->agent->browser() }}

                                                @if ($authSession->is_current_device)
                                                    <span class="ml-2 badge badge-online">{{ __('Huidig apparaat') }}</span>
                                                @endif
                                            </h6>

                                            <div class="small text-gray-info">
                                                <span class="mr-3">{{ $authSession->ip_address }}</span>
                                                {{ __('Laatst actief: :timestamp', ['timestamp' => $authSession->last_active]) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if ($canLogoutAuthSessions)
                            <div class="card-footer">
                                <div class="float-right">
                                    <button type="submit" data-toggle="modal" data-target="#logoutModal" class="btn btn-primary border-0 shadow-sm">
                                        {{ __('Andere sessies beëindigen') }}
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" id="sessionForm" action="{{ route('account.delete-sessions') }}" class="modal-body">
                    @csrf {{-- Form field protection --}}

                    <h4 class="mb-3 font-weight-bold text-bruin">{{ __('Afmelden van andere browser sessies in de applicatie.') }}</h4>

                    <p class="card-text text-bijna-zwart">
                        {{ __('Om all je browser sessie verspreid over alle apparaten uit te loggen vragen we je wachtwoord ter bevestiging. ') }}
                        {{ __('Zo kunnen we zeker zijn dat u de houder ben van het account.') }}
                    </p>

                    <hr>

                    <div class="form-row">
                        <input type="password" class="form-control" name="password-confirmation" placeholder="{{ __('Uw huidige wachtwoord') }}">
                    </div>
                </form>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn border-0 shadow-sm btn-secondary" data-dismiss="modal">{{ __('Nevermind') }}</button>
                    <button type="submit" form="sessionForm" class="btn border-0 shadow-sm btn-primary">
                        <x-heroicon-o-logout class="icon"/> {{ __('Andere browsers afmelden') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
