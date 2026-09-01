@aware(['size' => 'md'])

<div
    data-slot="button-icon"
    {{ $attributes->class([
        match ($size) {
            'sm' => '*:data-[slot=icon]:size-4',
            'lg' => '*:data-[slot=icon]:size-6',
            default => '*:data-[slot=icon]:size-5',
        },
        '[text-box-trim:trim-both]',
    ]) }}
>
    {{ $slot }}
</div>