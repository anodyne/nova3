@props([
    'markdown' => false,
])

<div
    @class([
        'nv-lead text-lg/8 text-gray-600 dark:text-gray-300',
        'space-y-6' => $markdown,
        $attributes->get('class') => $attributes->has('class'),
    ])
>
    @if ($markdown)
        {!! str($slot)->markdown() !!}
    @else
        {{ $slot }}
    @endif
</div>
