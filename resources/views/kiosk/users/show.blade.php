<x-app-kiosk-layout :title="$user->name">
    <div class="container-fluid py-3">
        <div class="page-header">
            <h1 class="page-title text-bruin">{{ __('Gebruikers') }}</h1>
            <div class="page-subtitle">{{ __('Algemene informatie omtrent :user', ['user' => $user->name]) }}</div>

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
                <div class="card card-body border-0 shadow-sm">
                    <h6 class="border-bottom border-gray pb-1 mb-3">{{ __('Algemene informatie omtrent :user', ['user' => $user->name]) }}</h6>

                    <div class="table-responsive">
                        @if ($user->isBanned())
                            <p class="card-text text-danger">
                                <x-heroicon-o-exclamation class="icon mr-1"/>
                                {{ __('Het gebruikers account van :user is gedeactiveerd door :creator', ['user' => $user->name, 'creator' => $user->banInformation()->createdBy->name]) }}
                            </p>
                            <hr>
                        @endif

                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="w-50 pt-1 px-0">
                                        <span class="font-weight-bold text-muted">{{ __('Naam + Achternaam') }}</span> <br>
                                        {{ $user->name }}
                                        <x-user-status-label :user="$user"/>
                                    </td>
                                    <td class="w-50 pt-1">
                                        <span class="font-weight-bold text-muted">{{ __('Email adres') }}</span> <br>
                                        {{ $user->email }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-50 px-0 {{ ($user->isBanned()) ? 'pb-1' : 'pb-0' }} pt-1">
                                        <span class="font-weight-bold text-muted">{{ __('Permissie rol') }}</span> <br>
                                        @forelse ($user->roles as $role)
                                            {{ $role->name }}
                                        @empty
                                            <x-heroicon-o-information-circle class="icon mr-1"/>
                                            {{ __('De gebruiker heeft op dit moment geen permissie rol.') }}
                                        @endforelse
                                    </td>
                                </tr>

                                @if ($user->isBanned())
                                    <tr>
                                        <td colspan="2" class="w-100 px-0 pb-0">
                                            <span class="text-muted font-weight-bold">Deactivation reason</span> <br>
                                            {{ $user->banInformation()->comment }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-kiosk-layout>
