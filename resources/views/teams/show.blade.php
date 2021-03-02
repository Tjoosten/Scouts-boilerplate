<x-app-layout :title="$team->name">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title text-donkergroen">{{ $team->name }}</h1>
            <div class="page-subtitle">{{ __('Uw huidige ploeg') }}</div>

            <div class="page-options d-flex">
                @if (count($teams) > 0)
                    <div class="dropdown mr-2">
                        <button class="btn btn-primary border-0 shadow-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <x-heroicon-o-menu class="icon mr-1"/> {{ __('switch ploeg') }}
                        </button>
                        <div class="dropdown-menu border-0 shadow-sm" aria-labelledby="dropdownMenuButton">
                            @foreach ($teams as $team)
                                <a href="" class="dropdown-item">
                                    {{ $team->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="container pt-3">
        <div class="row">
            <div class="col-12 pb-4">
                @include ('teams._navigation', ['team' => $team])
            </div>

            <div class="col-3">
                <h5 class="text-bijna-zwart font-weight-bold">{{ __('Ploeg informatie') }}</h5>
                <p class="small text-muted">{{ __('De algemene gegevens van de ploeg') }}</p>
            </div>

            <div class="offset-1 col-8">
                <x-form method="PUT" :action="__('home')" class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group mb-0 col-12">
                                <label for="name">{{ __('Naam van de ploeg') }} <span class="text-danger font-weight-bold">*</span></label>
                                <input id="name" value="{{ old('name') ?? $team->name }}" type="text" class="@error('name') is-invalid @enderror form-control" @if (! auth()->user()->isOwnerOfTeam($team)) disabled @endif>
                                <x-error class="invalid-feedback" field="name"/>
                            </div>
                        </div>
                    </div>

                    @if (auth()->user()->isOwnerOfTeam($team))
                        <div class="card-footer border-top-0">
                            <button type="submit" class="float-right btn btn-primary border-0 shadow-sm">
                                {{ __('Opslaan') }}
                            </button>
                        </div>
                    @endif
                </x-form>
            </div>
        </div>

        <hr class="my-4">

        <div class="row">
            <div class="col-3">
                <h5 class="text-bijna-zwart font-weight-bold">{{ __('Ploeg verwijderen') }}</h5>
                <p class="small text-muted">
                    {{ __('Verwijder de ploeg permanent uit :application', ['application' => config('app.name')]) }}
                </p>
            </div>

            <div class="offset-1 col-8">
                <x-form method="DELETE" :action="route('home')" class="card border-0 shadow-sm">
                    <div class="card-body">
                        <p class="card-text">
                            {{ __('Bij het verwijderen van een ploeg. Zal alle data permanent omtrent de ploeg worden verwijderd.') }}
                            {{ __('En de ploeg leden zullen ook losgekoppeld worden. Deze actie zal niet ongedaan kunnen gemaakt worden.') }}
                            {{ __('Vandaar dat we u vragen om zeker te zijn van de verwijdering.') }}
                        </p>

                        <hr>

                        <div class="form-row mb-0">
                            <div class="form-group col-md-8 mb-0">
                                <label for="password" class="sr-only">{{ __('Het huidige wachtwoord van je account.') }}</label>
                                <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" aria-describedby="passwordHelpBlock" placeholder="{{ __('Uw huidig wachtwoord') }}">

                                @if ($errors->has('password'))
                                    <x-error class="invalid-feedback" field="password"/>
                                @else
                                    <small id="passwordHelpBlock" class="text-muted form-text">{{ __('Het huidige wachtwoord van je account.') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-top-0">
                        <button type="submit" class="btn btn-danger border-0 shadow-sm">
                            {{ __('Ploeg verwijderen') }}
                        </button>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
</x-app-layout>
