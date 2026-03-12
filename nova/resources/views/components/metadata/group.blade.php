@props([
    'size' => 'sm',
    'gap' => 'sm',
])

<div
    {{
        $attributes->class([
            'relative flex items-center',
            match ($gap) {
                'xs' => 'gap-2',
                'md' => 'gap-6',
                'lg' => 'gap-8',
                default => 'gap-4',
            },
            match ($size) {
                'xs' => 'text-xs/5',
                'md' => 'text-base/7',
                default => 'text-sm/6',
            },
        ])
    }}
>
    {{ $slot }}
</div>
