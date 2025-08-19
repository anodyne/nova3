@props([
    'size' => 'base',
])

<div
    data-slot="text"
    {{
        $attributes->class([
            'space-y-6 text-gray-600 dark:text-gray-300',
            match ($size) {
                'sm' => 'text-sm/6',
                'lg' => 'text-lg/8',
                'xl' => 'text-xl/8',
                default => 'text-base/7',
            },
        ])
    }}
>
    {!! str($slot)->markdown() !!}
</div>
