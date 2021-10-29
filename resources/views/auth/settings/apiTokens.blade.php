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
                        <div class="form-group">
                            <label for="name">{{ __('Service naam') }}</label>
                            <input type="text" placeholder="{{ __('Naam voor je API token') }}" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                            <x-error class="invalid-feedback" field="name"/>
                        </div>

                        <hr>

                        <h5 class="mb-0">Token scopes</h5>
                        <p class="pb-3 mb-0 card-text text-muted">Scopes definiëren de toegang voor persoonlijke tokens van de API.</p>

                        <div class="form-group mx-3 mb-0">@foreach($tokenAbilities as $ability)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox"
                                           name="tokenAbilities[]"
                                           value="$ability"
                                           class="custom-control-input"
                                           id="{{ $ability['name'] }}"
                                    >

                                    <label class="custom-control-label row" for="{{ $ability['name'] }}">
                                        <div class="col-3 pl-1">{{ $ability['name'] }}</div>
                                        <div class="col-9 text-muted">{{ $ability['description'] }}</div>
                                    </label>
                                </div>
                            @endforeach
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
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        @if ($hasTokens)
                            <div class="table-responsive">
                                @if (session('message'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session()->get('message') }}
                                    </div>
                                @endif

                                <table class="table table-sm table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th class="border-top-0 w-50" scope="col">Naam</th>
                                        <th class="border-top-0" colspan="2" scope="col">Laatst gebruikt</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tokens as $token)
                                            <tr>
                                                <td class="font-weight-bold text-muted">{{ $token->name }}</td>
                                                <td>
                                                    @if ($token->last_used_at)
                                                        {{ $token->last_used_at->diffForHumans() }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('api.tokens.revoke', $token) }}" class="text-decoration-none small text-danger float-right">
                                                        <x:heroicon-o-trash class="icon"/> revoke
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <span class="text-muted font-weight-bold">
                                <x:heroicon-o-information-circle class="icon mr-1"/> {{ __('Momenteel hebt u nog geen API tokens in :applicatie', ['applicatie' => config('app.name')]) }}
                            </span>
                        @endif
                    </div>

                    @if ($tokens->hasPages())
                        <div class="card-footer border-top-0">
                            <div class="row">
                                <div class="col">{{ $tokens->onEachSide(3)->links() }}</div>
                                <div class="col text-secondary text-right my-auto">
                                    {{ $tokens->firstItem() }} tot {{ $tokens->lastItem() }} van {{ $tokens->total() }} API sleutels
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('token'))
        <div class="modal fade" id="tokenModal" tabindex="-1" role="dialog" aria-labelledby="tokenModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-modal-header border-0">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('API sleutel aangemaakt') }}</h5>
                    </div>
                    <div class="modal-body pt-0">
                        Hier is je nieuwe api sleutel. Dit is de enige keer dat je hem te zien krijgt.
                        Indien je de api sleutel niet meer gebruikt kan je hem altijd revoken in je API settings
                        <hr class="mt-2">

                        <textarea cols="3" class="form-control">{{ session()->get('token') }}</textarea>
                    </div>
                    <div class="modal-footer bg-modal-footer border-0">
                        <button type="button" class="btn btn-primary border-0 shadow-sm" data-dismiss="modal">{{ __('Sluiten') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            window.addEventListener('load', function() {
                $(function() { $('#tokenModal').modal('show') });
            })
        </script>
    @endif
</x-app-layout>
