 <x-form method="POST" class="card border-0 shadow-sm" :action="$$url">
 	<div class="card-body">
        @if (session('error'))
            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
        @elseif (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif
    </div>
</x-form>
