@component('mail::message')
# {{ __('Uitnodiging om je aan te sluiten bij de ploeg ' . $invite->team->name) }}

{{ __("Je bent uitgenodigd om je aan te sluiten bij de ploeg {$invite->team->name}.") }}
{{ __('Klik op een van de onderstaande knoppen om de uitnodiging te aceepteren of te weigeren.') }}

<div style="text-align: center; margin-top: 15px; margin-bottom: 25px;">
    <a href="" class="button button-green">{{ __('Accepteren') }}</a>
    <a href="" class="button button-red">{{ __('Weigeren') }}</a>
</div>

{{ __('Met vriendelijke groet') }},<br>
{{ config('app.name') }}
@endcomponent
