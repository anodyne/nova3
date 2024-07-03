@props([
    'size' => 'base',
])

<div
    data-slot="text"
    @class([
        'space-y-6 text-gray-600 dark:text-gray-300',
        match ($size) {
            'sm' => 'text-sm/5 sm:text-xs/5',
            'lg' => 'text-lg/7 sm:text-base/7',
            'xl' => 'text-xl/8 sm:text-lg/8',
            default => 'text-base/6 sm:text-sm/6',
        },
        $attributes->get('class') => $attributes->has('class'),
    ])
>
    {!! str($slot)->markdown() !!}
</div>
