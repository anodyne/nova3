@props([
    'action',
    'method' => 'POST',
])

<form
    action="{{ $action }}"
    method="{{ $method === 'GET' ? 'GET' : 'POST' }}"
    role="form"
    {{ $attributes->merge(['data-cy' => 'form']) }}
>
    @csrf

    @if (! in_array($method, ['GET', 'POST']))
        @method($method)
    @endif

    {{ $slot }}
</form>
