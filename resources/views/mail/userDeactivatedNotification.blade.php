@component('mail::message')
# {{ __('Deactivatie van je account.') }}

{{ __('Via deze weg willen we je informeren dat je account op :application is gedactiveerd.', ['application' => config('app.name')]) }}
{{ __('Wegens de volgende reden:') }} {{ $reason }}

{{ __('Indien u vragen hebt of denkt dat dit een vergissing u kunt u contact opnemen met een administrator.') }}

{{ __('Met vriendelijke groet,') }}<br>
{{ config('app.name') }}
@endcomponent
