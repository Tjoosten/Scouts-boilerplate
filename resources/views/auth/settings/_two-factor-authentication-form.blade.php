<div class="card border-0 shadow-sm">
    <div class="card-body">
        @csrf {{-- Form field protection --}}

        @if ($twoFactorAuthenticationDisabled)
            <p class="card-text text-danger">
                <x:heroicon-o-shield-exclamation class="icon mr-1"/>
                {{ __('Two factor authenticatie is nog niet activeerd voor je gebruikersaccount.') }}
            </p>
        @elseif ($twoFactorAuthenticationEnabled)
            <p class="card-text text-success">
                <x:heroicon-o-shield-check class="icon mr-1"/>
                {{ __('Two Factor authentication is geactiveerd voor je gebruikersaccount') }}
            </p>
        @endif

        <p class="card-text">
            {{ __('Wanneer two factor authenticatie is ingeschakeld, wordt u tijdens de authenticatie om een veilige,') }}
            {{ __('willekeurige token gevraagd. U kunt deze token ophalen uit de Google Authenticator-app van uw telefoon.') }}
        </p>

        @if ($twoFactorAuthenticationDisabled)
            <p class="card-text">
                {{ __('Om de activatie ervan te starten vragen we je hieronder je wachtwoord in te geven om zeker te zijn dat jij de huidige eigenaar bent van het gebruikers account.') }}
            </p>

            <hr class="mt-0">

            <form action="{{ route('two-factor.enable') }}" method="POST">
                @csrf {{-- Form field protection --}}

                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="passwordConfirmation" class="sr-only">{{ __('Wachtwoord bevestiging (vereist)') }}</label>
                        <input type="password"
                               class="form-control"
                               name="current_password"
                               id="passwordConfirmation"
                               placeholder="{{ __('Uw huidig wachtwoord.') }}"
                        >
                    </div>

                    <div class="form-group col-12 mb-0">
                        <button type="submit" class="btn btn-primary shadow-sm border-0">
                            {{ __('Activeer 2FA') }}
                        </button>
                    </div>
                </div>
            </form>
        @endif

        @if ($twoFactorAuthenticationEnabled)
            @if (session('showingQrCode'))
                <p class="card-text">
                    {{ __('Two factor authenticatie is geactiveerd. Scan de volgende QR code met de Google Authenticator app die geinstalleerd is op je smartphone.') }}
                </p>

                {!! auth()->user()->twoFactorQrCodeSvg() !!}
            @endif

            @if (session('showingRecoveryCodes'))
                <p class="card-text @if (session('showingQrCode')) mt-3 @endif">
                    {{ __('Bewaar deze herstelcodes in een veilige wachtwoordbeheerder.') }}
                    {{ __('Ze kunnen worden gebruikt om de toegang tot uw account te herstellen als uw apparaat voor tweefactorauthenticatie verloren is gegaan.') }}
                </p>
            @endif
        @endif

        @if ($twoFactorAuthenticationEnabled)
            <hr class="mt-0">

            <a href="" class="btn border-0 shadow-sm btn-primary mr-1">
                {{ __('Genereer herstelcodes') }}
            </a>

            <a href="{{ route('two-factor.disable') }}" class="btn btn-danger shadow-sm btn-danger">
                {{ __('Deactiveer 2FA') }}
            </a>
        @endif
    </div>
</div>
