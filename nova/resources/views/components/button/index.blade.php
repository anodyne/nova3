@props([
    'leading' => false,
    'trailing' => false,
    'size' => 'base',
    'color' => 'neutral',
    'variant' => null,
    'postToUrl' => null,
])

@php
    $size = match ($size) {
        'xs' => 'xs',
        'sm' => 'sm',
        'lg' => 'lg',
        default => 'base',
    };

    $scaling = 'active:scale-98 active:transition active:duration-150';

    $container = 'flex items-center gap-2';

    // If posting, make a unique form id and wire the button to it.
    $formId = $postToUrl ? ('btn-form-'.Str::uuid()) : null;

    // Button attrs differ depending on whether we’re posting.
    $buttonAttrs = [
        'data-slot' => 'button',
        'type' => $postToUrl ? 'submit' : 'button',
    ];

    if ($postToUrl) {
        $buttonAttrs['form'] = $formId;
    }
@endphp

<flux:button :$variant :$size {{ $attributes->merge($buttonAttrs)->class([$scaling, $container]) }}>
    {{ $slot }}
</flux:button>

@if ($postToUrl)
    <form id="{{ $formId }}" action="{{ $postToUrl }}" method="POST" class="hidden">
        @csrf
    </form>
@endif
