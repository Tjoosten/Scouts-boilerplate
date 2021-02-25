<x-app-layout :title="__('Account instellingen')">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title text-donkergroen">{{ auth()->user()->name }}</h1>
            <div class="page-subtitle">{{ __('Informatie instellingen') }}</div>
        </div>
    </div>

    <div class="container pt-3">
        <div class="row">
            @include ('auth.settings._settings-nav')

            <div class="col-3">
                <h5 class="text-bijna-zwart font-weight-bold">{{ __('Account informatie') }}</h5>
                <p class="small text-muted">{{ __('Pas jouw naam en account email adres aan.') }}</p>
            </div>

            <div class="offset-1 col-8">
                <x-form method="PUT" class="card border-0 shadow-sm" :action="route('user-profile-information.update')">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">{{ __('Naam')  }}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('name', 'updateProfileInformation') is-invalid @enderror" name="name" id="name" value="{{ auth()->user()->name ?? old('name') }}">
                                <x-error class="invalid-feedback" field="name" bag="updateProfileInformation"/>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label for="email" class="col-sm-4 col-form-label">{{ __('Email adres') }}</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control @error('email', 'updateProfileInformation') is-invalid @enderror" name="email" id="email" value="{{ auth()->user()->email ?? old('email') }}">
                                <x-error class="invalid-feedback" field="email" bag="updateProfileInformation"/>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer border-top-0">
                        <div class="row">
                            @if (session('informationUpdated'))
                                <div class="col my-auto text-success font-weight-bold">
                                    <x-heroicon-o-check-circle class="icon"/> {{ __('Account informatie aangepast.') }}
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

        <hr class="my-4">

        <div class="row pb-4">
            <div class="col-3">
                <h5 class="text-bijna-zwart font-weight-bold">{{ __('Account verwijderen') }}</h5>
                <p class="small text-muted">{{ __('Verwijder je account permanent uit de applicatie.') }}</p>
            </div>

            <div class="offset-1 col-8">
                <x-form class="card shadow-sm border-0" method="DELETE" :action="route('account.delete')">
                    <div class="card-body">
                        <p class="card-text">
                            {{ __('Bij het verwijderen van je account. Zal al je data permanent verwijderd worden.') }}
                            {{ __('Als ook zal de verwijdering niet ongedaan gemaakt kunnen worden, vandaar') }}
                            {{ __('dat je we willen vragen om zeker te zijn over het verwijderen van je account.') }}
                        </p>

                        <hr>

                        <div class="form-row mb-0">
                            <div class="form-group col-md-8 mb-0">
                                <label for="password" class="sr-only">{{ __('Het huidige wachtwoord van je account.') }}</label>
                                <input id="password"  type="password" class="form-control" aria-describedby="passwordHelpBlock" placeholder="{{ __('Uw huidig wachtwoord') }}">
                                <small id="passwordHelpBlock" class="text-muted form-text">{{ __('Het huidige wachtwoord van je account.') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-top-0">
                        <button type="submit" class="btn btn-danger border-0 shadow-sm">
                            <x-heroicon-o-trash class="icon"/> {{ __('Account verwijderen') }}
                        </button>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
</x-app-layout>
