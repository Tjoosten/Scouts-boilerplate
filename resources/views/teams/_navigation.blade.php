<ul class="nav-settings nav-overflow nav">
    <li class="nav-item">
        <a class="nav-link {{ active('teams.show') }}" href="{{ route('teams.show', $team) }}">
            <x-heroicon-o-information-circle class="icon mr-1"/> {{ __('Informatie') }}
        </a>
    </li>

    @if (auth()->user()->isOwnerOfTeam($team))
        <li class="nav-item">
            <a class="nav-link {{ active('teams.members.index')  }}" href="{{ route('teams.members.index', $team) }}">
                <x-heroicon-o-users class="icon mr-1"/> {{ __('Leden') }}
            </a>
        </li>
    @endif
</ul>
