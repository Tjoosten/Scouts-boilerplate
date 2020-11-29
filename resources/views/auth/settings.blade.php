@extends ('layouts.app')

@section ('content')
    <div class="container pb-4">
        <div class="page-header">
            <h1 class="page-title text-donkergroen">{{ $user->name }}</h1>
            <div class="page-subtitle">{{ __('account instellingen') }}</div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-3">
                <h5 class="text-bijna-zwart font-weight-bold">{{ __('Account informatie') }}</h5>
                <p class="small text-muted">{{ __('Pas jouw naam en account email adres aan.') }}</p>
            </div>

            <div class="offset-1 col-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                    </div>

                    <div class="card-footer border-top-0">
                        <div class="float-right">
                            <button type="submit" class="btn btn-primary border-0">{{ __('Opslaan') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="row">
            <div class="col-3">
                <h5 class="text-bijna-zwart font-weight-bold">{{ __('Account beveiliging') }}</h5>
                <p class="small text-muted">{{ __('Gebruik bij het wijzigen van je wachtwoord een lang en robust wachtwoord.') }}</p>
            </div>

            <div class="offset-1 col-8">
                <form method="POST" action="" class="card border-0 shadow-sm">
                    @csrf

                    <div class="card-body">
                        <div class="form-group row">
                            <label for="currentPassword" class="col-sm-4 col-form-label">{{ __('Huidig wachtwoord') }}</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="currentPassword" placeholder="{{ __('huidig wachtwoord') }}">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label for="newPassword" class="col-sm-4 col-form-label">{{ __('Nieuw wachtwoord') }}</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control" id="newPassword" placeholder="{{ __('nieuw wachtwoord') }}">
                            </div>
                            <div class="col-sm-4">
                                <input type="email" class="form-control" id="newPassword" placeholder="{{ __('wachtwoord confirmatie') }}">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer border-top-0">
                        <div class="float-right">
                            <button type="submit" class="btn btn-primary border-0">{{ __('Opslaan') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <hr class="my-4">

        <div class="row pb-4">
            <div class="col-3">
                <h5 class="text-bijna-zwart font-weight-bold">{{ __('Account verwijderen') }}</h5>
                <p class="small text-muted">{{ __('Verwijder je account permanent uit de applicatie.') }}</p>
            </div>

            <div class="offset-1 col-8">
                <form method="POST" action="" class="card shadow-sm border-0">
                    @csrf
                    @method('delete')

                    <div class="card-body">
                        <p class="card-text pb-2">
                            {{ __('Bij het verwijderen van je account. Zal al je data permanent verwijderd worden.') }}
                            {{ __('Als ook zal de verwijdering niet ongedaan gemaakt kunnen worden, vandaar') }}
                            {{ __('dat je we willen vragen om zeker te zijn over het verwijderen van je account.') }}
                        </p>

                        <button type="submit" class="btn btn-danger border-0">
                            <x-heroicon-o-trash class="icon"/> {{ __('Account verwijderen') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
