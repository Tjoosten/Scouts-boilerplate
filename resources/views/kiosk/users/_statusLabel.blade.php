@if ($user->isNotBanned())
    <span class="ml-2 badge badge-online">{{ __('Actieve gebruiker') }}</span>
@elseif ($user->isBanned())
    <span class="ml-2 badge badge-nonactive">{{ __('Deactivated') }}</span>
@endif
