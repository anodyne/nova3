@props([
    'title' => false,
    'message' => false,
])

<div class="form-section" {{ $attributes }}>
    @if ($title || $message)
        <div class="form-section-header">
            @if ($title)
                <h3 class="form-section-header-title">{{ $title }}</h3>
            @endif

            @if ($message)
                <div class="form-section-header-message">{{ $message }}</div>
            @endif
        </div>
    @endif

    <div class="form-section-content">
        {{ $slot }}
    </div>
</div>
