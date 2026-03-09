@props([
    'divided' => false,
])

<x-spacing {{
    $attributes->class([
        'divide-y divide-gray-950/5 dark:divide-white/10' => $divided,
    ])
}}>
    {{ $slot }}
</x-spacing>
