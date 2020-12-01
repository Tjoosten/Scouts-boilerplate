<form method="{{ $method !== 'GET' ? 'POST' : 'GET' }}" action="{{ $action }}" class="{{ $class }}">
    @csrf
    @method($method)

    {{ $slot }}
</form>
