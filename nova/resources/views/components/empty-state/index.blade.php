@props([
    'variant' => null,
])

<div
    {{
        $attributes->class([
            // Base styles
            'flex flex-col items-center',

            // Variant styles
            match ($variant) {
                'jumbo' => 'p-8 [&>[data-slot=icon]]:size-16',
                'compact' => 'p-4 [&>[data-slot=icon]]:size-12',
                default => 'p-0 [&>[data-slot=icon]]:size-12'
            },

            // Icon styles
            '[&>[data-slot=icon]]:text-gray-400 dark:[&>[data-slot=icon]]:text-gray-500',

            // Text styles
            '[&>[data-slot=text]]:text-center [&>[data-slot=text]]:text-gray-500',

            // Spacing styles
            '[&>[data-slot=icon]+[data-slot=heading]]:mt-4',
            '[&>[data-slot=icon]+[data-slot=text]]:mt-4',
            '[&>[data-slot=heading]+[data-slot=text]]:mt-2',
            '[&>[data-slot=heading]+[data-slot=button]]:mt-8',
            '[&>[data-slot=text]+[data-slot=button]]:mt-8',
        ])
    }}
>
    {{ $slot }}
</div>
