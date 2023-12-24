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
            'size-8' => $size === 'xs',
            'size-10' => $size === 'sm',
            'size-12' => $size === 'md',
            'size-16' => $size === 'lg',
            'size-24' => $size === 'xl',
            match (settings('appearance.avatarShape')) {
                'squircle' => 'mask mask-squircle',
                'hexagon' => 'mask mask-hexagon',
                'hexagon-alt' => 'mask mask-hexagon-alt',
                default => settings('appearance.avatarShape'),
            },
        ])
    }}
/>
