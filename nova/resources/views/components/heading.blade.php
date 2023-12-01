@props([
    'level',
])

@php($tag = "h{$level}")

<{{ $tag }}
    {{
        $attributes->class([
            'block',
            match ((int) $level) {
                1 => 'text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-3xl',
                2 => 'text-xl font-bold tracking-tight text-gray-900 dark:text-white',
                3 => 'text-lg font-semibold text-gray-700 dark:text-gray-300',
                4 => 'text-base font-medium text-gray-700 dark:text-gray-300',
                default => 'text-base text-gray-600 dark:text-gray-400',
            },
            $attributes->get('class'),
        ])
    }}
>
    {{ $slot }}
</{{ $tag }}>
