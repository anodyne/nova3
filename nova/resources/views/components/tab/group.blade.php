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
        'inline-flex items-center gap-x-1.5 overflow-x-scroll rounded-full bg-gray-950/[.08] px-[5px] py-1 text-sm/6 dark:bg-white/5',
        $attributes->get('class') => $attributes->has('class'),
    ])
>
    {{ $slot }}
</div>
