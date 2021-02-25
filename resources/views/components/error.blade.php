@error($field, $bag ?? null)
    <div {{ $attributes }}>
        @if ($slot->isEmpty())
            {{ $message }}
        @else
            {{ $slot }}
        @endif
    </div>
@enderror
