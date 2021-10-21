@props([
    'as' => 'panel',
    'onEdge' => false,
])

<div data-cy="{{ $as }}" @class([
    'bg-gray-1 shadow' => $as === 'panel',
    'bg-gray-6' => $as === 'well',
    'bg-gray-3' => $as === 'light well',
    'sm:rounded-lg' => true,
]) {{ $attributes }}>
    {{ $slot }}
</div>
