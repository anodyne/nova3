@props([
    'size' => 'md',
    'color' => 'neutral',
    'postToUrl' => null,
    'leading' => false,
    'trailing' => false,
])

@php
    $isLink = $attributes->has('href');
    $isIconButton = false;

    // If posting, make a unique form id and wire the button to it.
    $formId = $postToUrl ? ('btn-form-'.Str::uuid()) : null;

    $styles = [
        'relative inline-flex items-center justify-center gap-1',
        'has-data-[slot=button-content]:gap-3',
        'rounded-full [text-box-trim:trim-both]',
        'active:scale-98 active:transition active:duration-150',
        match ($size) {
            'sm' => 'text-xs font-medium h-6 px-3',
            'lg' => 'text-base font-semibold h-10 data-[slot=button]:px-7 data-[slot=icon-button]:w-10',
            default => 'text-sm font-medium h-8 px-5'
        },
        match ($color) {
            'accent' => 'bg-gray-800 text-white hover:bg-gray-700',
            'primary' => 'bg-primary-500 text-white hover:brightness-105',
            'ghost' => 'bg-transparent hover:bg-gray-950/7 text-gray-600',
            'danger' => 'bg-red-600 hover:brightness-105 text-white',
            default => 'bg-gray-950/7 hover:bg-gray-950/10 text-gray-600',
        },
    ];

    $buttonAttrs = [
        'data-slot' => $isIconButton ? 'icon-button' : 'button',
        'type' => $postToUrl ? 'submit' : 'button',
    ];

    if ($postToUrl) {
        $buttonAttrs['form'] = $formId;
    }

    if ($isLink) {
        unset($buttonAttrs['type']);
    }
@endphp

@if ($isLink)
    <a {{ $attributes->merge($buttonAttrs)->class($styles) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge($buttonAttrs)->class($styles) }}>
        {{ $slot }}
    </button>

    @if ($postToUrl)
        <form id="{{ $formId }}" action="{{ $postToUrl }}" method="POST" class="hidden">
            @csrf
        </form>
    @endif
@endif