@props([
    'tag' => 'p',
    'color' => 'neutral',
    'size' => 'md',
])

<{{ $tag }}
    {{
        $attributes->class([
            match ($color) {
                'heavy' => 'text-gray-700 dark:text-gray-300',
                'subtle' => 'text-gray-500 dark:text-gray-500',
                default => 'text-gray-600 dark:text-gray-400',
            },
            match ($size) {
                'lg' => 'text-xl lg:text-lg',
                'sm' => 'text-base lg:text-sm',
                'xl' => 'text-2xl lg:text-xl',
                'xs' => 'text-sm lg:text-xs',
                default => 'text-lg lg:text-base',
            },
            $attributes->get('class'),
        ])
    }}
>
    {{ $slot }}
</{{ $tag }}>
