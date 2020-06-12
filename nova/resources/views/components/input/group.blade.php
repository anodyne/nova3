@props([
    'label' => false,
    'for' => false,
    'help' => false,
    'error' => false,
])

<div {{ $attributes->merge(['class' => $error ? 'field-wrapper has-error' : 'field-wrapper']) }}>
    @if ($label)
        <label class="field-label" for="{{ $for }}">
            {{ $label }}
        </label>
    @endif

    {{ $slot }}

    @if ($error)
        <div class="field-error" role="alert">
            @icon('alert')
            <span>{{ $error }}</span>
        </div>
    @endif

    @if ($help)
        <div class="field-help" role="note">
            {{ $help }}
        </div>
    @endif
</div>
