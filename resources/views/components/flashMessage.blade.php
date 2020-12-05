@if (flash()->message)
    <div class="border-0 rounded-0 mb-0 alert {{ flash()->class }}">
        {{ flash()->message }}
    </div>
@endif
