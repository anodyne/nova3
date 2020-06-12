@props([
    'action',
    'method' => 'POST',
])

<form action="{{ $action }}" method="{{ $method }}" role="form" {{ $attributes->merge(['data-cy' => 'form']) }}>
    @csrf

    @if ($method !== 'GET' || $method !== 'POST')
        @method($method)
    @endif

    {{ $slot }}
</form>