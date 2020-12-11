<x-app-kiosk-layout :title="__('Gebruikers')">
    <div class="container-fluid py-3">
        <div class="page-header">
            <h1 class="page-title color-bruin">{{ __('Gebruikers') }}</h1>
            <div class="page-subtitle">{{ __('Overzicht van alle gebruikers in :application', ['application' => config('app.name')]) }}</div>

            <div class="page-options d-flex">
                <a href="{{ route('kiosk.users.create') }}" class="btn btn-primary border-0 shadow-sm">
                    <x-heroicon-o-user-add class="icon"/>
                </a>

                <div class="btn-group mx-2">
                    <button type="button" class="btn btn-primary border-0 shadow-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <x:heroicon-o-filter class="icon mr-1"/> {{ __('Filter') }}
                    </button>
                    <div class="dropdown-menu border-0 shadow-sm">
                        <a class="dropdown-item" href="{{ route('kiosk.users.index') }}">{{ __('Alle gebruikers') }}</a>
                        <a class="dropdown-item" href="{{ route('kiosk.users.index', ['filter' => 'activated']) }}">{{ __('Geactiveerde gebruikers') }}</a>
                        <a class="dropdown-item" href="{{ route('kiosk.users.index', ['filter' => 'deactivated']) }}">{{ __('Gedeactiveerde gebruikers') }}</a>
                    </div>
                </div>

                <form method="GET" action="{{ route('kiosk.users.search') }}" class="form-inline">
                    <input type="text" name="term" value="{{ request('term') }}" class="form-control form-search border-0 shadow-sm" placeholder="{{ __('Zoek bij naam of email adres') }}">
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid pb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="border-top-0" scope="col">{{ __('Naam')  }}</th>
                                <th class="border-top-0" scope="col">{{ __('Status') }}</th>
                                <th class="border-top-0" scope="col">{{ __('Email adres') }}</th>
                                <th class="border-top-0" scope="col" colspan="2">{{ __('Registratie datum') }}</th> {{-- Colspan="2" is needed for the fynctions --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user) {{-- Loop trough the users --}}
                                <tr>
                                    <td class="text-muted font-weight-bold">{{ $user->name }}</td>
                                    <td><x-user-status-label :user="$user"/></td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        {{ $user->created_at->format('d-m-Y') }}
                                        <span class="small text-muted">({{ $user->created_at->diffForHumans() }})</span>
                                    </td>
                                    <td>
                                        <span class="float-right">
                                            <a href="{{ route('kiosk.users.show', $user) }}" class="text-muted text-decoration-none mr-3">
                                                <x-heroicon-o-eye class="icon"/>
                                            </a>

                                            <a href="mailto:{{ $user->email }}" class="text-muted text-decoration-none mr-1">
                                                <x-heroicon-o-mail class="icon"/>
                                            </a>

                                            <a href="{{ route('kiosk.users.edit', $user) }}" class="text-muted text-decoration-none mr-1">
                                                <x-heroicon-o-pencil class="icon"/>
                                            </a>

                                            <a href="{{ route('kiosk.users.delete', $user) }}" class="text-danger text-decoration-none mr-1">
                                                <x-heroicon-o-trash class="icon"/>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                            @empty {{-- There are no users found --}}
                                <tr>
                                    <td colspan="5" class="text-muted">
                                        <x-heroicon-o-exclamation class="icon mr-1"/>
                                        {{ __('Momenteel zijn er geen gebruikers gevonden met de matchende filter.') }}
                                    </td>
                                </tr>
                            @endforelse {{-- END for loop --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-kiosk-layout>
