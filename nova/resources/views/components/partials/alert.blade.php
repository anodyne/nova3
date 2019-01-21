<div class="alert alert-{{ session('alert.type') }}">
    @if (session()->has('alert.title'))
        <div class="alert-title">{{ session('alert.title') }}</div>
    @endif

    <p class="alert-message">{{ session('alert.message') }}</p>
</div>