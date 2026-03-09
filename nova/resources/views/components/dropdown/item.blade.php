@props([
    'icon' => false,
    'postToUrl' => null,
])

@php
    // If posting, make a unique form id and wire the button to it.
    $formId = $postToUrl ? ('btn-form-'.Str::uuid()) : null;

    // Button attrs differ depending on whether we’re posting.
    $menuAttrs = [
        'type' => $postToUrl ? 'submit' : 'button',
    ];

    if ($postToUrl) {
        $menuAttrs['form'] = $formId;
    }
@endphp

<flux:menu.item {{ $attributes->merge($menuAttrs) }}>
    @if ($icon)
        <x-icon :name="$icon" size="sm" class="me-2" data-flux-menu-item-icon="data-flux-menu-item-icon" />
    @endif

    {{ $slot }}
</flux:menu.item>

@if ($postToUrl)
    <form id="{{ $formId }}" action="{{ $postToUrl }}" method="POST" class="hidden">
        @csrf
    </form>
@endif
