@props([
    'action',
    'method' => 'POST',
])

@php
    $formMethod = ($method !== 'GET' || $method !== 'POST') ? 'POST' : $method;
@endphp

<form action="{{ $action }}" method="{{ $formMethod }}" role="form" {{ $attributes->merge(['data-cy' => 'form']) }}>
    @csrf

    @if ($method !== 'GET' || $method !== 'POST')
        @method($method)
    @endif

    {{ $slot }}
</form>
