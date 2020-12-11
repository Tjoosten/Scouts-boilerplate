<x-app-kiosk-layout :title="__('Activiteiten log')">
    <div class="container-fluid py-3">
        <div class="page-header">
            <h1 class="page-title text-bruin">{{ __('Gebruikers') }}</h1>
            <div class="page-subtitle">{{ __('Overzicht van alle gelogde activiteiten van :user', ['user' => $user->name]) }}</div>

            <div class="page-options d-flex">
                <a href="{{ route('kiosk.users.index') }}" class="btn btn-primary border-0 shadow-sm">
                    <x-heroicon-o-users class="icon mr-1"/> {{ __('Gebruikers overzicht') }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid pb-3">
        <div class="row">
            <div class="col-md-3">
                <x-user-side-navigation :user="$user"/>
            </div>

            <div class="col-md-9">
                <div class="card border-0 shadow-sm ">
                    <div class="card-body">
                        <h6 class="border-bottom border-gray pb-1 mb-3">{{ __('Overzicht van alle gelogd activiteiten van :user', ['user' => $user->name]) }}</h6>

                        @if ($activities->total() > 0)
                            <table class="table table-hover table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-top-0 w-15" scope="col">{{ __('Log naam') }}</th>
                                        <th class="border-top-0 w-65" scope="col">{{ __('Beschrijving') }}</th>
                                        <th class="border-top-0 w-20" scope="col">{{ __('Timestamp') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activities as $activity)
                                        <tr>
                                            <td class="text-muted font-weight-bold">{{ $activity->log_name }}</td>
                                            <td>{{ $activity->description }}</td>
                                            <td>{{ $activity->created_at->format('d/m/Y - H:i:s') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="card-text text-warning">
                                <x-heroicon-o-information-circle class="icon mr-1"/>
                                {{ __('Momenteel zijn er nog geen handelingen van :user kom later nog eens terug.', ['user' => $user->name]) }}
                            </p>
                        @endif
                    </div>

                    @if ($activities->hasPages())
                        <div class="card-footer border-top-0">
                            <div class="row">
                                <div class="col">{{ $activities->links() }}</div>
                                <div class="col text-secondary text-right my-auto">
                                    {{ $activities->firstItem() }} tot {{ $activities->lastItem() }} van {{ $activities->total() }} activiteiten
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-kiosk-layout>
