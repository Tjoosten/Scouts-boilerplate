@component('mail::message')
# {{ __('Verwijdering van je account.') }}

{{ __('Hey :user', ['user' => $user->name]) }}

{{ __('Via deze weg willen we je informeren dat je account op :application efinitief is verwijderd.', ['application' => config('app.name')]) }}
{{ __('Indien u de website toch terug wenst gebruiken kun je je simpelweg terug opnieuw registreren.') }}

{{ __('Met vriendelijke groet,') }}<br>
{{ config('app.name') }}
@endcomponent
