<div class="list-group list-group-transparent">
    <a href="{{ route('kiosk.users.show', $user) }}" class="{{ active('kiosk.users.show') }} list-group-item list-group-item-action">
        <x-heroicon-o-eye class="icon mr-2"/> {{ __('Bekijk gebruiker') }}
    </a>
    <a href="{{ route('kiosk.users.activities', $user) }}" class="{{ active('kiosk.users.activities') }} list-group-item list-group-item-action">
        <x-heroicon-o-view-list class="icon mr-2"/> {{ __('Gebruikers activiteiten') }}
    </a>
    <a href="{{ route('kiosk.users.edit', $user) }}" class="{{ active('kiosk.users.edit') }} list-group-item list-group-item-action">
        <x-heroicon-o-pencil class="icon mr-2"/> {{ __('Wijzig gebruiker') }}
    </a>

    @can('deactivate', $user)
        <a href="{{ route('kiosk.users.deactivate', $user) }}" class="{{ active('kiosk.users.deactivate') }} list-group-item list-group-item-action">
            <x-heroicon-o-lock-closed class="icon mr-2"/> {{ __('Deactiveer gebruiker') }}
        </a>
    @endcan

    @can ('activate', $user)
        <a href="{{ route('kiosk.users.activate', $user) }}" class="list-group-item list-group-item-action">
            <x-heroicon-o-lock-open class="icon mr-2"/> {{ __('Activeer gebruiker') }}
        </a>
    @endcan

    <a href="{{ route('kiosk.users.delete', $user) }}" class="{{ active('kiosk.users.delete') }} list-group-item list-group-item-action">
        <x-heroicon-o-trash class="icon mr-2 text-danger"/> {{ __('Verwijder gebruiker') }}
    </a>
</div>
