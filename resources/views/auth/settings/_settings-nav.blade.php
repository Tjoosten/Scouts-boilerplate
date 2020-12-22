<div class="col-12 pb-4">
    <ul class="nav-settings nav-overflow nav">
        <li class="nav-item">
            <a class="nav-link {{ active('account.settings.information') }}" href="{{ route('account.settings.information') }}">
                <x-heroicon-o-information-circle class="icon mr-1"/> {{ __('Informatie') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ active('account.settings.security') }}" href="{{ route('account.settings.security') }}">
                <x-heroicon-o-key class="icon mr-1"/> {{ __('Beveiliging') }}
            </a>
        </li>
    </ul>
</div>
