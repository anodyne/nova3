@props([
    'action',
    'footer' => false,
    'method' => 'POST',
    'divide' => true,
    'space' => true,
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

    <div @class([
        'divide-y divide-gray-3' => $divide,
        'space-y-4 md:space-y-8' => $space,
    ])>
        {{ $slot }}
    </div>
</form>
