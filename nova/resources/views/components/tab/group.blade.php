@props([
    'name' => '',
    'color' => 'blue',
])

@php
    $name = preg_replace('/[\s]/', '-', $name);
    if ($name == '') {
        exit('you need to specify the name property of the tab');
    }
@endphp

<div
    data-slot="tabs"
    @class([
        'inline-flex w-full gap-x-2 rounded-xl bg-gray-950/[.04] p-1 ring-1 ring-inset ring-gray-950/[.025] lg:w-auto dark:bg-white/[.04]',
        $attributes->get('class') => $attributes->has('class'),
    ])
>
    {{ $slot }}
</div>
