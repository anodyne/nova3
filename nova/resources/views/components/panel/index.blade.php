@props([
    'as' => 'panel',
])

@php
    $styles = Illuminate\Support\Arr::toCssClasses([
        'sm:rounded-lg',
        'bg-white dark:bg-gray-900 shadow dark:shadow-md ring-1 ring-gray-900/5 dark:ring-gray-800' => $as === 'panel',
        'bg-white dark:bg-gray-900 ring-1 ring-gray-900/5 dark:ring-gray-800' => $as === 'no-shadow',
        'bg-gray-100 dark:bg-gray-800' => $as === 'light-well',
        'bg-gray-50 dark:bg-gray-900/50' => $as === 'extra-light-well',
        'bg-gray-200 dark:bg-gray-700' => $as === 'well',
    ])
@endphp

<div
    data-cy="{{ $as }}"
    {{ $attributes->merge(['class' => $styles]) }}
>
    {{ $slot }}
</div>
