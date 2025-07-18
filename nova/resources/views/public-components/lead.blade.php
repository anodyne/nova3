@props([
    'markdown' => false,
])

<div
    {{
        $attributes->class([
            'nv-lead text-lg/8',
            'space-y-6' => $markdown,
        ])
    }}
>
    @if ($markdown)
        {!! str($slot)->markdown() !!}
    @else
        {{ $slot }}
    @endif
</div>
