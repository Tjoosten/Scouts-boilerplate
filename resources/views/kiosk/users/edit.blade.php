<x-app-kiosk-layout :title="__('Wijzig gebruiker')">
    <div class="container-fluid py-3">
        <div class="page-header">
            <h1 class="page-title text-bruin">{{ __('Gebruikers') }}</h1>
            <div class="page-subtitle">{{ __('Account gevevens wijzigen van :user', ['user' => $user->name]) }}</div>

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
               <x-user-side-navigation :user="$user"/>
            </div>

            <div class="col-9">
                <x-form method="PATCH" class="card border-0 shadow-sm" :action="route('kiosk.users.update', $user)">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-7">
                                <label for="name">{{ __('Naam') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $user->name }}">
                                <x-error class="invalid-feedback" field="name"/>
                            </div>
                            <div class="form-group col-5">
                                <label for="role">{{ __('Permissie groep') }}</label>

                                <select id="role" class="custom-select @error('role') is-invalid @enderror" name="role">
                                    <option value="">-- {{ __('Selecteer permissie groep') }} --</option>

                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" @if ($user->hasRole($role->name) || old('role') === $user->role) selected @endif>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>

                                <x-error class="invalid-feedback" field="role"/>
                            </div>
                            <div class="form-group col-12 mb-0">
                                <label for="email">{{ __('Email adres') }}</label>
                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $user->email }}">
                                <x-error class="invalid-feedback" field="email"/>
                            </div>
                        </div>

                        <hr>

                        <div class="form-row">
                            <div class="form-group col-6 mb-0">
                                <label for="password">{{ __('Wachtwoord') }}</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                <x-error class="invalid-feedback" field="password"/>
                            </div>

                            <div class="form-group col-6 mb-0">
                                <label for="confirmation">{{ __('Herhaal wachtwoord') }}</label>
                                <input type="password" class="form-control" id="password" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-top-0">
                        <div class="float-right">
                            <button type="submit" class="btn btn-primary border-0">{{ __('Opslaan') }}</button>
                        </div>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
</x-app-kiosk-layout>
