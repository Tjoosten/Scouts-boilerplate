<x-app-layout :title="__('API tokens')">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title text-donkergroen">{{ $user->name }}</h1>
            <div class="page-subtitle">{{ __('Persoonlijke API tokens') }}</div>
        </div>
    </div>

    <div class="container pt-3">
        <div class="row">
            @include ('auth.settings._settings-nav')

            <div class="col-3">
                <h5 class="text-bijna-zwart font-weight-bold">{{ __('API token aanmaken') }}</h5>
                <p class="small text-muted">{{ __('API tokens staan toe om applicaties van derden te authenticeren met deze applicatie.') }}</p>
            </div>
            <div class="offset-1 col-8">
                <x-form method="POST" class="card border-0 shadow-sm" :action="route('api.tokens.store')">
                    <div class="card-body">
                        <div class="form-group mb-0">
                            <label for="name">{{ __('Service naam') }}</label>
                            <input type="text" placeholder="{{ __('Naam voor je API token') }}" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                            <x-error class="invalid-feedback" field="name"/>
                        </div>
                    </div>
                    <div class="card-footer border-top-0">
                        <div class="row">
                            <div class="col text-secondary text-right my-auto">
                                <button type="submit" class="btn btn-primary border-0">{{ __('Aanmaken') }}</button>
                            </div>
                        </div>
                    </div>
                </x-form>
            </div>
        </div>

        <hr class="my-4">

        <div class="row pb-4">
            <div class="col-3">
                <h5 class="text-bijna-zwart font-weight-bold">{{ __('Beheer API tokens') }}</h5>
                <p class="small text-muted">{{ __('Je kan tokens die niet meer worden gebruikt makkelijk verwijderen of bekijken.') }}</p>
            </div>
            <div class="offset-1 col-8">
                <div class="card card-body border-0 shadow-sm">
                    @if ($hasTokens)

                    @else
                        <span class="text-muted font-weight-bold">
                            <x:heroicon-o-information-circle class="icon mr-1"/> {{ __('Momenteel hebt u nog geen API tokens in :applicatie', ['applicatie' => config('app.name')]) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
