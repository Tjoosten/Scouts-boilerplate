<x-app-layout :title="__('Ploeg leden')">
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
                <h5 class="text-bijna-zwart font-weight-bold">{{ __('Lid uitnodigen') }}</h5>
                <p class="small text-muted">{{ __('Een ploeg is niets zonder leden. Hier kun je een lid toevoegen') }}</p>
            </div>

            <div class="offset-1 col-8">
                <x-form method="POST" class="card border-0 shadow-sm" :action="route('teams.members.store', $team)">
                    <div class="card-body">
                        @if (session()->has('invitation'))
                            <div class="alert alert-warning border-0" role="alert">
                                {{ session('invitation') }}
                            </div>
                        @endif

                        <p class="card-text">
                            {{ __('Geef het e-mailadres op van de persoon die u wilt toevoegen aan deze ploeg.') }}
                            {{ __('Het e-mailadres moet aan een bestaand account zijn gekoppeld') }}
                        </p>

                        <hr>

                        <div class="form-row">
                            <div class="form-group col-8 mb-0">
                                <label class="sr-only" for="email">Email <span class="text-danger text-decoration-none">*</span></label>
                                <input type="email" placeholder="{{ __('Email adres van het toekomstig lid') }}" required id="email" name="email" class="form-control @error('email') is-invalid @enderror">
                                <x-error field="email" class="invalid-feedback"/>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-top-0">
                        <button type="submit" class="border-0 btn btn-primary float-right shadow-sm">
                            {{ __('Uitnodigen') }}
                        </button>
                    </div>
                </x-form>
            </div>
        </div>

        <hr class="my-4">

        <div class="row">
            <div class="col-3">
                <h5 class="text-bijna-zwart font-weight-bold">{{ __('Uitstaande uitnodigingen') }}</h5>
                <p class="small text-muted">{{ __('Een klein overzicht van gebruikers die je hebt uitgenodigd voor je ploeg.') }}</p>
            </div>

            <div class="offset-1 col-8">
                <div class="card card-body shadow-sm border-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0 @if ($invites->total() > 0) table-hover @endif">
                            <thead>
                            <tr>
                                <th class="border-top-0" scope="col">{{ __('Naam') }}</th>
                                <th class="border-top-0" scope="col">{{ __('Uitgenodigd op') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($invites as $person)
                                    <tr>
                                        <td class="font-weight-bold">{{ $person->user->name }} <span class="small text-muted">({{ $person->email }})</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-muted">
                                            <x-heroicon-o-information-circle class="icon mr-1"/> {{ __('Momenteel zijn er geen openstaande uitnodigingen.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="row">
            <div class="col-3">
                <h5 class="text-bijna-zwart font-weight-bold">{{ __('Ploegleden') }}</h5>
                <p class="small text-muted">{{ __('Een huidig overzicht van alle ploegleden.') }}</p>
            </div>
            <div class="offset-1 col-8">
                <div class="card card-body border-0 shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="border-top-0" scope="col">{{ __('Functie') }}</th>
                                    <th class="border-top-0" scope="col">{{ __('Naam') }}</th>
                                    <th colspan="2" class="border-top-0" scope="col">{{ __('Lid sinds') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $member)
                                    <tr>
                                        <td>
                                            @if ($member->isOwnerOfTeam($team))
                                                <span class="badge badge-info">{{ __('Eigenaar') }}</span>
                                            @else
                                                <span class="badge badge-info">{{ __('Lid') }}</span>
                                            @endif
                                        </td>
                                        <td class="font-weight-bold">{{ $member->name }}<span class=" ml-1 text-muted small">({{ $member->email }})</span></td>
                                        <td>{{ $member->pivot->created_at->diffForHumans() }}</td>

                                        @if (! $member->isOwnerOfTeam($team))
                                            <a href="" class="text-danger float-right text-decoration-none">
                                                <x-heroicon-o-trash class="icon"/>
                                            </a>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
