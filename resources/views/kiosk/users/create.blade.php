<x-app-kiosk-layout :title="__('Gebruiker toevoegen')">
    <div class="container-fluid py-3">
        <div class="page-header">
            <h1 class="page-title text-bruin">{{ __('Gebruikers') }}</h1>
            <div class="page-subtitle">{{ __('Toevoegen van een nieuwe gebruiker in :application', ['application' => config('app.name')]) }}</div>

            <div class="page-options d-flex">
                <a href="{{ route('kiosk.users.index') }}" class="btn btn-primary border-0 shadow-sm">
                    <x-heroicon-o-users class="icon mr-1"/> {{ __('Gebruikers overzicht') }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid pb-3">
        <div class="row">
            <div class="col-3">
                <h5 class="color-bijna-zwart">{{ __('Algemene informatie') }}</h5>
                <p class="small text-muted">{{ __('Alle nodige informatie van de nieuwe gebruiker in :application.', ['application' => config('app.name')]) }}</p>
            </div>

            <div class="offset-1 col-8">
                <x-form method="POST" class="card border-0 shadow-sm" :action="route('kiosk.users.store')">
                    <div class="card-body">
                        <h6 class="border-bottom border-gray pb-1 mb-3">{{ __('Toevoegen van een nieuwe gebruiker in :application', ['application' => config('app.name')]) }}</h6>

                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">{{ __('Name') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}">
                                <x-error class="invalid-feedback" field="name"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">{{ __('Email adres') }}</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}">
                                <x-error class="invalid-feedback" field="email"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-sm-3 col-form-label mb-0">{{ __('Permissie groep') }}</label>
                            <div class="col-sm-9 mb-0">
                                <select class="custom-select @error('role') is-invalid @enderror" name="role" id="role">
                                    <option value="">-- {{ __('Selecteer de permissie groep van de gebruiker.')  }} --</option>
                                    @foreach ($roles as $role) {{-- Loop trough the roles --}}
                                        <option value="{{ $role->name }}" @if ($role->name === old('role')) selected @endif>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>

                                <x-error class="invalid-feedback" field="role"/>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label mb-0">{{ __('Wachtwoord') }}</label>
                            <div class="col-sm-9 mb-0">
                                <input type="password" class="form-control @error('email') is-invalid @enderror" name="password" id="password" value="{{ old('email') }}">
                                <x-error class="invalid-feedback" field="password"/>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <label for="password-confirmation" class="col-sm-3 col-form-label mb-0">{{ __('Herhaal wachtwoord') }}</label>
                            <div class="col-sm-9 mb-0">
                                <input type="password" class="form-control" name="password_confirmation" id="password-confirmation">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer border-top-0">
                        <div class="float-right">
                            <button type="submit" class="btn btn-primary">{{ __('Opslaan') }}</button>
                        </div>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
</x-app-kiosk-layout>
