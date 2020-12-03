@if (flash()->message)
    <div class="border-0 rounded-0 mb-0 alert {{ flash()->class }}">
        @if (flash()->class === 'alert-danger')
            <span class="font-weight-bold mr-2"><x-heroicon-o-exclamation-circle class="icon"/> {{ __('Foutmelding:') }}</span>
            {{ flash()->message }}
        @endif
    </div>
@endif
