@props([
    'as' => 'panel',
    'onEdge' => false,
])

<div data-cy="{{ $as }}" @class([
    'bg-gray-1 shadow' => $as === 'panel',
    'bg-gray-4' => $as === 'well',
    'bg-gray-2' => $as === 'light well',
    '-mx-4 sm:mx-0 sm:rounded-lg' => true,
]) {{ $attributes }}>
    {{ $slot }}
</div>
