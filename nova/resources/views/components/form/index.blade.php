@props([
    'action',
    'footer' => false,
    'method' => 'POST',
    'space' => true,
])

<form
    action="{{ $action }}"
    method="{{ $method === 'GET' ?: 'POST' }}"
    role="form"
    {{ $attributes->merge(['data-cy' => 'form']) }}
>
    @csrf

    @unless (in_array($method, ['GET', 'POST']))
        @method($method)
    @endunless

    <div @class([
        'space-y-12' => $space,
    ])>
        {{ $slot }}
    </div>
</form>
