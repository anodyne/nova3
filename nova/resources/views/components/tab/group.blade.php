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
        'inline-flex w-full gap-x-2 lg:w-auto',
        $attributes->get('class') => $attributes->has('class'),
    ])
>
    {{ $slot }}
</div>
