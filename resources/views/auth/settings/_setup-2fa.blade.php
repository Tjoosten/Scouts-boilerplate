<x-form method="POST" class="card border-0 shadow-sm" :action="$url">
    <div class="card-body">
        @if (session('error'))
            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
        @elseif (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif

        <p class="card-text">
            {{ __('Wanneer Two factor authenticatie is geactiveerd, wordt u tijdens de authenticatie om een veilige,') }}
            {{ __('willekeurige token gevraagd. U kunt dit token ophalen uit de Google Authenticator-applicatie van uw telefoon.') }}
        </p>

        <p class="card-text">{{ __('Op 2FA authenticatie te activeren. Voert u simpelweg de volgende stappen uit.') }}</p>

        <ul class="list-unstyled mb-1 font-weight-bold">
            <li>1. {{ __("Klik op de 'activeer 2FA' knop onderin om je unieke 2FA installatie token te genereren.") }}</li>
            <li>2. {{ __('Verifieer de token in de Google authenticator app op je telefoon.') }}</li>
        </ul>
    </div>

    <div class="border-top-0 card-footer">
        <div class="float-right">
            <button type="submit" class="btn btn-primary border-0 shadow-sm">
                {{ __('Activeer 2FA') }}
            </button>
        </div>
    </div>
</x-form>
