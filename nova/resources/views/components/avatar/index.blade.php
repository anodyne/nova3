@props([
    'src',
    'size' => 'md',
    'tooltip' => '',
])

<img
    src="{{ $src }}"
    alt="{{ $tooltip }}"
    {{
        $attributes->class([
            'relative inline-block bg-white object-cover ring-2 ring-white dark:bg-gray-900 dark:ring-gray-900',
            'h-8 w-8' => $size === 'xs',
            'h-10 w-10' => $size === 'sm',
            'h-12 w-12' => $size === 'md',
            'h-16 w-16' => $size === 'lg',
            'h-24 w-24' => $size === 'xl',
            match (settings('appearance.avatarShape')) {
                'squircle' => 'mask mask-squircle',
                'hexagon' => 'mask mask-hexagon',
                'hexagon-alt' => 'mask mask-hexagon-alt',
                default => settings('appearance.avatarShape'),
            },
        ])
    }}
/>
