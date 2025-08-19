@props([
    'divided' => false,
    'striped' => false,
])

<x-spacing {{
    $attributes->class([
        'divide-y divide-gray-950/5 dark:divide-white/5' => $divided,
    ])
}}>
    {{ $slot }}
</x-spacing>
